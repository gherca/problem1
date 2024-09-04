<?php

namespace App\Discount\Application\DTO;

use App\Discount\Domain\Entities\DiscountItem;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class DiscountData extends Data
{
    public function __construct(
        public int $id,
        #[DataCollectionOf(DiscountItem::class)]
        public DataCollection $discounts,
        public float $total,
        public float $totalWithDiscounts,
    )
    {
    }
}
