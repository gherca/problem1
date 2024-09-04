<?php

namespace App\Discount\Domain\Entities;

use Spatie\LaravelData\Data;

class DiscountItem extends Data
{
    public function __construct(
        public float $amount,
        public string $reason
    )
    {
    }
}
