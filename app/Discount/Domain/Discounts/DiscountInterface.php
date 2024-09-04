<?php

namespace App\Discount\Domain\Discounts;

use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Domain\Entities\DiscountItem;

interface DiscountInterface
{
    public function apply(RequestOrderDiscountData $requestOrderDiscountData): ?DiscountItem;
}
