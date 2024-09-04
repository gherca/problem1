<?php

namespace Tests\Unit\Discount\Domain;

use App\Discount\Application\Discounts\LoyaltyDiscount;
use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Domain\Entities\DiscountItem;
use App\Discount\Domain\Services\DiscountManager;
use Tests\Concerns\ExampleOrdersTrait;
use Tests\TestCase;

class DiscountManagerTest extends TestCase
{
    use ExampleOrdersTrait;

    public function test_apply_discounts_with_empty_strategies_return_empty(): void
    {
        $requestOrderDiscountData = RequestOrderDiscountData::from([
            'id' => '1',
            'customer-id' => '1',
            'items' => [],
            'total' => 0,
        ]);
        $discountManager = new DiscountManager([]);
        $this->assertEmpty($discountManager->applyDiscounts($requestOrderDiscountData));
    }

    public function test_apply_discounts_loyalty_success(): void
    {
        $requestOrderDiscountData = RequestOrderDiscountData::from(self::order2Data());
        $discountManager = new DiscountManager([
            app(LoyaltyDiscount::class)
        ]);

        $this->assertTrue(
            $discountManager
                ->applyDiscounts($requestOrderDiscountData)
                ->contains('amount', 2.495)
        );
    }

    public function test_not_apply_discounts_loyalty_success(): void
    {
        $requestOrderDiscountData = RequestOrderDiscountData::from(self::order1Data());
        $discountManager = new DiscountManager([
            app(LoyaltyDiscount::class)
        ]);

        $this->assertEmpty($discountManager->applyDiscounts($requestOrderDiscountData));
    }
}
