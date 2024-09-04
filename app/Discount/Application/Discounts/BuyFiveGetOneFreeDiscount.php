<?php

namespace App\Discount\Application\Discounts;

use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Application\DTO\RequestOrderDiscountItemData;
use App\Discount\Domain\Discounts\DiscountInterface;
use App\Discount\Domain\Entities\DiscountItem;
use App\Product\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\Config;

class BuyFiveGetOneFreeDiscount implements DiscountInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    )
    {
    }

    public function apply(RequestOrderDiscountData $requestOrderDiscountData): ?DiscountItem
    {
        $products = $this->productRepository->findByCategoryId(Config::get('discounts.buy_five_get_one_free_category_id'));
        $productsIds = $products->pluck('id');

        $productsList = $requestOrderDiscountData->items
            ->toCollection()
            ->whereIn('productId', $productsIds);

        $productsList->each(function (RequestOrderDiscountItemData $orderItemData) {
            if ($orderItemData->quantity >= Config::get('discounts.buy_five_get_one_free_minimum_products')) {
                ++$orderItemData->quantity;
                $orderItemData->discount = DiscountItem::from([
                    'amount' => 0,
                    'reason' => 'Buy 5 Switches get 1 free'
                ]);
            }
        });

        return null;
    }
}
