<?php

namespace Amirhome\LaravelSubscriptionManagment;

use Amirhome\LaravelSubscriptionManagment\Concerns\ContractUI;
use Amirhome\LaravelSubscriptionManagment\Events\SubscriptionCanceled;
use Amirhome\LaravelSubscriptionManagment\Events\SubscriptionRenewd;
use Amirhome\LaravelSubscriptionManagment\Events\SubscriptionStarted;
use Amirhome\LaravelSubscriptionManagment\Events\SubscriptionSuppressed;
use Amirhome\LaravelSubscriptionManagment\Events\SubscriptionSwitched;
use Amirhome\LaravelSubscriptionManagment\Exceptions\SubscriptionRequiredExp;
use Amirhome\LaravelSubscriptionManagment\Exceptions\SwitchToSamePlanExp;
use Amirhome\LaravelSubscriptionManagment\Handler\ContractsHandler;
use Amirhome\LaravelSubscriptionManagment\Handler\SubscriptionBuilder;
use Amirhome\LaravelSubscriptionManagment\Models\Subscription;
use Amirhome\LaravelSubscriptionManagment\Models\SubscriptionContract;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

class LaravelSubscriptionManagment
{
    private ?Subscription $subscription;
    private ContractsHandler $contractsHandler;

    public static function make(Model $subscriber): self
    {
        return new self($subscriber);
    }

    private function __construct(private readonly Model $subscriber)
    {
        $this->subscription = $this->loadFreshSubscription();
        if ($this->subscription) {
            $this->contractsHandler = new ContractsHandler($this->subscription);
        }
    }

    public function reload(): self
    {
        $this->subscription = $this->loadFreshSubscription();
        $this->contractsHandler = new ContractsHandler($this->subscription);

        return $this;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }

    private function loadFreshSubscription(): ?Subscription
    {
        if (!method_exists($this->subscriber, "getSubscription")) {
            throw new \LogicException("Subscriber should implement HasSubscription Trait");
        }

        return $this->subscriber->getSubscription(true);
    }

    /**
     * @throws \Throwable
     */
    public function subscribeTo(ContractUI $item, string|CarbonInterface|null $startAt = null, int $period = 1): self
    {
        $this->subscription = SubscriptionBuilder::make($this->subscriber)
            ->setPlan($item)
            ->setStartDate($startAt)
            ->setPeriod($period)
            ->create();

        $this->reload();
        $this->refresh();

        event(new SubscriptionStarted($this->subscription));

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function switchTo(ContractUI $item, string|CarbonInterface|null $startAt = null, ?int $period = null, bool $withPlugins = true): self
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);
        throw_if($this->subscription->plan_id === $item->getKey(), SwitchToSamePlanExp::class);

        $startAt ??= $this->subscription->start_at;
        $this->suppress($startAt);
        $plugins = $this->contractsHandler->getActivePlugin();
        $this->subscription = SubscriptionBuilder::make($this->subscriber)
            ->setPlan($item)
            ->setStartDate($startAt)
            ->setPeriod($period ?? $this->subscription->getBillingPeriod())
            ->create();

        $this->reload();

        if ($withPlugins) {
            $plugins->each(fn(SubscriptionContract $contract) => $this->contractsHandler->install($contract->product, $this->subscription->subscriber, $startAt));
        }

        $this->refresh();

        event(new SubscriptionSwitched($this->subscription));

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function cancel(string|CarbonInterface|null $cancelDate = null): self
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);

        $cancelDate = $cancelDate ? carbonParse($cancelDate) : now();
        $this->subscription->update(['canceled_at' => $cancelDate]);

        event(new SubscriptionCanceled($this->subscription));

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function resume(): self
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);

        $this->subscription->update(['canceled_at' => null]);

        event(new SubscriptionCanceled($this->subscription));

        return $this;
    }

    /**
     * @throws \Throwable
     */
    private function suppress(string|CarbonInterface|null $suppressionDate = null): void
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);

        $suppressionDate = $suppressionDate ? carbonParse($suppressionDate) : now();
        $this->subscription->update(['suppressed_at' => $suppressionDate]);

        event(new SubscriptionSuppressed($this->subscription));
    }

    /**
     * @throws \Throwable
     */
    public function setUnlimitedAccess(bool $value = true): void
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);
        $this->subscription->update(['unlimited' => $value]);
    }

    /**
     * @throws \Throwable
     */
    public function renew(?int $period = null, bool $withPlugins = true): self
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);

        $period = $period ?: $this->subscription->getBillingPeriod();
        $lastEndDate = $this->subscription->end_at;
        $endDate = $lastEndDate->clone()->addMonths($period)->endOfDay();
        $this->subscription->update(['end_at' => $endDate]);

        if ($withPlugins) {
            $this->contractsHandler->getActivePlugin()->each(function (SubscriptionContract $contract) use ($lastEndDate) {
                $this->contractsHandler->install($contract->product, $this->subscription->subscriber, $lastEndDate->addDay());
            });
        }

        $this->reload();
        $this->refresh();

        event(new SubscriptionRenewd($this->subscription));

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function addPlugin(ContractUI $item, string|CarbonInterface|null $startAt = null, ?Model $causative = null): self
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);

        $this->contractsHandler->install($item, $causative ?? $this->subscription->subscriber, $startAt);

        $this->reload();
        $this->refresh();

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function cancelPlugin(ContractUI $item, ?Model $causative = null): self
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);

        $this->contractsHandler->cancel($item, $causative ?? $this->subscription->subscriber);

        $this->reload();

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function resumePlugin(ContractUI $item, ?Model $causative = null): self
    {
        throw_if(!$this->subscription, SubscriptionRequiredExp::class);

        $this->contractsHandler->resume($item, $causative ?? $this->subscription->subscriber);

        $this->reload();

        return $this;
    }

    public function refresh(): self
    {
        $this->contractsHandler->sync();

        return $this;
    }
}
