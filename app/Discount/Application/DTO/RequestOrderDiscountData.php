<?php

namespace App\Discount\Application\DTO;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class RequestOrderDiscountData extends Data
{
    public function __construct(
        public int $id,
        #[MapInputName('customer-id')]
        public int $customerId,
        #[DataCollectionOf(RequestOrderDiscountItemData::class)]
        public DataCollection $items,
        public float $total
    )
    {
    }
}
