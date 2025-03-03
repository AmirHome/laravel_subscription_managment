<?php

namespace Amirhome\LaravelSubscriptionManagment\Concerns;

use Amirhome\LaravelSubscriptionManagment\Models\Feature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @see Model
 *
 * @method mixed getKey()
 */
interface ContractUI
{
    public function getCode(): string;

    public function isRecurring(): bool;

    /** @return Collection<Feature> */
    public function getFeatures(): Collection;
}
