<?php

namespace Tests\Unit\Discount\Application;

use App\Discount\Application\DTO\DiscountData;
use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Application\Services\DiscountService;
use App\Discount\Domain\Services\DiscountManager;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;


class DiscountServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDiscountManager = $this->createMock(DiscountManager::class);
        $this->discountService = new DiscountService($this->mockDiscountManager);
    }

    #[DataProvider('providerOrders')]
    public function test_get_discounts_return_them_same_id($data): void
    {
        $this->mockDiscountManager->expects($this->once())->method('applyDiscounts')->willReturn(collect());
        $this->assertEquals(
            $data['id'],
            $this->discountService->getDiscounts(RequestOrderDiscountData::from($data))->id
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
