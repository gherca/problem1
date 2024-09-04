<?php

namespace App\Discount\Application\Services;

use App\Discount\Application\DTO\DiscountData;
use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Application\DTO\RequestOrderDiscountItemData;
use App\Discount\Domain\Entities\DiscountItem;
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
        $generalDiscounts = $this->discountManager->applyDiscounts($requestOrderDiscountData);
        $total = $requestOrderDiscountData->items->toCollection()->sum(function ($item) {
            return $item->total;
        });

        $totalOfGeneralDiscounts = $generalDiscounts->sum(function (DiscountItem $item) {
            return $item->amount;
        });

        $totalOfItemDiscounts = $requestOrderDiscountData->items->toCollection()->sum(function (RequestOrderDiscountItemData $item) {
            return $item->discount instanceof DiscountItem
                ? $item->discount->amount
                : null;
        });

        return DiscountData::from([
            'id' => $requestOrderDiscountData->id,
            'items' => $requestOrderDiscountData->items,
            'discounts' => $generalDiscounts,
            'total' => $total,
            'totalWithDiscounts' => $total - ($totalOfGeneralDiscounts + $totalOfItemDiscounts)
        ]);
    }
}
