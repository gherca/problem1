<?php

namespace App\Discount\Application\DTO;

use App\Discount\Domain\Entities\DiscountItem;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class RequestOrderDiscountItemData extends Data
{
    public function __construct(
        #[MapInputName('product-id')]
        public string $productId,
        public int $quantity,
        #[MapInputName('unit-price')]
        public float $unitPrice,
        public float $total,
        public DiscountItem|Optional $discount
    )
    {
    }
}
