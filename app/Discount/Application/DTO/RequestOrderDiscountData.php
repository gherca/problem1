<?php

namespace App\Discount\Application\DTO;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class RequestOrderDiscountData extends Data
{
    public function __construct(
        public int $id,
        #[MapInputName('customer-id')]
        public int $customerId,
        public array $items,
        public float $total
    )
    {
    }
}
