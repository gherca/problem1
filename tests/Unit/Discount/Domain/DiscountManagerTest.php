<?php

namespace Tests\Unit\Discount\Domain;

use App\Discount\Application\DTO\DiscountData;
use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Application\Services\DiscountService;
use App\Discount\Domain\Services\DiscountManager;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DiscountManagerTest extends TestCase
{

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

}
