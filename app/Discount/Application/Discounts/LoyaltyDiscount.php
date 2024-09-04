<?php

namespace App\Discount\Application\Discounts;

use App\Customer\Domain\Repositories\CustomerRepositoryInterface;
use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Domain\Discounts\DiscountInterface;
use App\Discount\Domain\Entities\DiscountItem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Number;

class LoyaltyDiscount implements DiscountInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
    )
    {
    }

    public function apply(RequestOrderDiscountData $requestOrderDiscountData): ?DiscountItem
    {
        $customer = $this->customerRepository->findById($requestOrderDiscountData->customerId);
        $minimRevenue = Config::get('discounts.loyalty_discount_customer_minimum_revenue');
        if ($customer->revenue > $minimRevenue) {
            return DiscountItem::from([
                'amount' => Number::format($requestOrderDiscountData->total * 0.10, 2),
                'reason' => '10% discount for customers who spent over €' . $minimRevenue,
            ]);
        }

        return null;
    }
}
