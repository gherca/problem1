<?php

namespace Feature\Discount;

use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\ExampleOrdersTrait;
use Tests\TestCase;

class DiscountControllerTest extends TestCase
{
    use ExampleOrdersTrait;

    #[DataProvider('provideAllOrders')]
    public function test_the_discount_returns_a_successful_response($data): void
    {
        $this->post(
            '/api/v1/discounts',
            $data
        )
            ->assertSuccessful()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['id', 'discounts', 'total', 'totalWithDiscounts']));
    }

    public function test_the_discount_returns_correct_two_discounts(): void
    {
        $orderData = self::order2Data();
        $this->post(
            '/api/v1/discounts',
            $orderData
        )
            ->assertSuccessful()
            ->assertExactJson([
                'id' => (int)$orderData['id'],
                'items' => [
                    [
                        'discount' => [
                            'amount' => 0,
                            'reason' => 'Buy 5 Switches get 1 free'
                        ],
                        'productId' => 'B102',
                        'quantity' => 6,
                        'total' => 24.95,
                        'unitPrice' => 4.99
                    ]
                ],
                'discounts' => [
                    [
                        'amount' => 2.495,
                        'reason' => '10% discount for customers who spent over €1000'
                    ]
                ],
                'total' => 24.95,
                'totalWithDiscounts' => 22.455,
            ]);
    }

    public function test_the_discount_returns_correct_buy_five_get_one_free_discount(): void
    {
        $orderData = self::order1Data();
        $this->post(
            '/api/v1/discounts',
            $orderData
        )
            ->assertSuccessful()
            ->assertExactJson([
                'id' => (int)$orderData['id'],
                'discounts' => [],
                'items' => [
                    [
                        'discount' => [
                            'amount' => 0,
                            'reason' => 'Buy 5 Switches get 1 free'
                        ],
                        'productId' => 'B102',
                        'quantity' => 11,
                        'total' => 49.90,
                        'unitPrice' => 4.99
                    ]
                ],
                'total' => 49.90,
                'totalWithDiscounts' => 49.90,
            ]);
    }

    public static function provideAllOrders(): array
    {
        return [
            [self::order1Data()],
            [self::order2Data()],
            [self::order3Data()]
        ];
    }
}
