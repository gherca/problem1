<?php

namespace App\Discount\Application\Services;

use App\Discount\Application\DTO\DiscountData;

class DiscountService
{
    public function getDiscounts(DiscountData $orderData)
    {
        return $orderData;
    }
}
