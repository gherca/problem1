<?php

namespace App\Discount\Domain\Services;

use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Domain\Entities\DiscountItem;
use Illuminate\Support\Collection;

class DiscountManager
{
    public function __construct(
        private readonly array $discountStrategies
    )
    {
    }

    public function applyDiscounts(RequestOrderDiscountData $requestOrderDiscountData): Collection
    {
        $generalDiscounts = collect();
        foreach ($this->discountStrategies as $discountStrategy) {
            /** @var ?DiscountItem $discount */
            $discount = $discountStrategy->apply($requestOrderDiscountData);
            if ($discount === null) {
                continue;
            }
            $generalDiscounts->push($discount);
        }

        return $generalDiscounts;
    }
}
