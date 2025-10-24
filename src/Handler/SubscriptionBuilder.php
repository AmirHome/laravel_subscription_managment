<?php

namespace Amirhome\LaravelSubscriptionManagment\Handler;

use Amirhome\LaravelSubscriptionManagment\Concerns\ContractUI;
use Amirhome\LaravelSubscriptionManagment\Exceptions\SubscriptionRequiredExp;
use Amirhome\LaravelSubscriptionManagment\Models\Subscription;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

class SubscriptionBuilder
{
    private ?ContractUI $plan = null;
    private string|CarbonInterface|null $startDate = null;
    private string|CarbonInterface|null $endDate = null;
    private int $period = 1;

    public static function make(Model $subscriber): self
    {
        return new self($subscriber);
    }

    private function __construct(private readonly Model $subscriber)
    {
    }

    public function setPlan(ContractUI $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    public function setStartDate(string|CarbonInterface|null $date): self
    {
        $this->startDate = $date;

        return $this;
    }

    public function getStartDate(): CarbonInterface
    {
        return carbonParse($this->startDate ?? now());
    }

    public function setEndDate(string|CarbonInterface|null $date): self
    {
        $this->endDate = $date;

        return $this;
    }

    public function getEndDate(): CarbonInterface
    {
        return carbonParse($this->endDate ?: $this->getStartDate()->addMonths($this->period));
    }

    public function setPeriod(int $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getPeriod(): int
    {
        return $this->endDate
            ? ceil($this->getStartDate()->diffInMonths($this->getEndDate()))
            : $this->period;
    }

    /**
     * @throws \Throwable
     */
    public function create(): Subscription
    {
        throw_if(!$this->plan, SubscriptionRequiredExp::class);

        $startAt = $this->getStartDate();
        $endAt = $this->getEndDate();

        /* @phpstan-ignore-next-line */
        return $this->subscriber->subscriptions()->create([
            'product_id' => $this->plan->getKey(),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'billing_period' => $this->period,
        ]);
    }
}
