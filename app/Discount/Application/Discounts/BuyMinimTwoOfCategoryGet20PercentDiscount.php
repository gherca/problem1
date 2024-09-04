<?php

namespace App\Discount\Application\Discounts;

use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Application\DTO\RequestOrderDiscountItemData;
use App\Discount\Domain\Discounts\DiscountInterface;
use App\Discount\Domain\Entities\DiscountItem;
use App\Product\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Number;

class BuyMinimTwoOfCategoryGet20PercentDiscount implements DiscountInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    )
    {
    }

    public function apply(RequestOrderDiscountData $requestOrderDiscountData): ?DiscountItem
    {
        $products = $this->productRepository->findByCategoryId(Config::get('discounts.buy_minimum_two_of_category_id'));
        $productsIds = $products->pluck('id');

        $productsList = $requestOrderDiscountData->items
            ->toCollection()
            ->whereIn('productId', $productsIds);

        $productsInCategory = 0;

        $productsList->each(function (RequestOrderDiscountItemData $requestOrderDiscountItemData) use (&$productsInCategory) {
            $productsInCategory += $requestOrderDiscountItemData->quantity;
        });

        if ($productsInCategory >= Config::get('discounts.buy_minimum_two_of_category_minimum_products')) {
            $productWithDiscount = $productsList->sortBy('unitPrice')->first();
            $productWithDiscount->discount = DiscountItem::from([
                'amount' => Number::format($productWithDiscount->unitPrice * 0.2, 2),
                'reason' => '20% discount on the cheapest Product',
            ]);
        }

        return null;
    }
}
