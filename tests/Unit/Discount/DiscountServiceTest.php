<?php

namespace Tests\Unit\Discount;

use App\Discount\Application\DTO\DiscountData;
use App\Discount\Application\Services\DiscountService;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;


class DiscountServiceTest extends TestCase
{
    #[DataProvider('providerOrders')]
    public function test_get_discounts_return_instance_of_discount_data($data): void
    {
        $this->assertInstanceOf(
            DiscountData::class,
            app(DiscountService::class)->getDiscounts(DiscountData::from($data))
        );
    }

    public static function providerOrders(): array
    {
        return [
            [
                [
                    'id' => '1',
                    'customer-id' => '2',
                    'items' => [
                        [
                            'product-id' => 'B102',
                            'quantity' => '5',
                            'unit-price' => '4.99',
                            'total' => '24.95'
                        ],
                    ],
                    'total' => '24.95'
                ]
            ]
        ];
    }
}
