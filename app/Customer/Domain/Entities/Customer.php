<?php

namespace App\Customer\Domain\Entities;

use Spatie\LaravelData\Data;

class Customer extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $since,
        public float $revenue
    )
    {
    }
}
