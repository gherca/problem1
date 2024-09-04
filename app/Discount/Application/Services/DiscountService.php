<?php

namespace App\Discount\Application\Services;

use App\Discount\Application\DTO\DiscountData;
use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Domain\Services\DiscountManager;

class DiscountService
{
    public function __construct(
        private readonly DiscountManager $discountManager,
    )
    {
    }

    public function getDiscounts(RequestOrderDiscountData $requestOrderDiscountData): DiscountData
    {
        $discounts = $this->discountManager->applyDiscounts($requestOrderDiscountData);

        return DiscountData::from([
            'id' => $requestOrderDiscountData->id,
            'discounts' => $discounts,
            'total' => 0,
            'totalWithDiscounts' => 0
        ]);
    }
}
