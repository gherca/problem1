<?php

namespace App\Product\Domain\Entities;

use Spatie\LaravelData\Data;

class Product extends Data
{
    public function __construct(
        public string $id,
        public string $description,
        public int $category,
        public float $price
    )
    {
    }
}
