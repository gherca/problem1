<?php

namespace Feature\Discount;

use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\ExampleOrdersTrait;
use Tests\TestCase;

class DiscountControllerTest extends TestCase
{
    use ExampleOrdersTrait;

    public function test_the_discount_returns_unprocessable_entity(): void
    {
        $this->post(
            '/api/v1/discounts'
        )
            ->assertUnprocessable();
    }

    public function test_the_discount_returns_not_found_for_customer(): void
    {
        $this->post(
            '/api/v1/discounts',
            array_merge(self::order1Data(), [
                'customer-id' => 999
            ])
        )
            ->assertNotFound();
    }

    #[DataProvider('provideAllOrders')]
    public function test_the_discount_returns_a_successful_response($data): void
    {
        $this->post(
            '/api/v1/discounts',
            $data
        )
            ->assertSuccessful()
            ->assertJson(fn(AssertableJson $json) => $json->hasAll(['id', 'items', 'discounts', 'total', 'totalWithDiscounts']));
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

    public function test_the_discount_returns_no_discounts_for_order3(): void
    {
        $orderData = self::order3Data();
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
                        'productId' => 'B102',
                        'quantity' => 2,
                        'unitPrice' => 9.75,
                        'total' => 19.50
                    ],
                    [
                        'productId' => 'A102',
                        'quantity' => 1,
                        'unitPrice' => 49.50,
                        'total' => 49.50
                    ]
                ],
                'total' => 69.00,
                'totalWithDiscounts' => 69.0,
            ]);
    }

    public function test_the_discount_returns_correct_buy_minim_two_of_category_discount(): void
    {
        $orderData = self::order3Data();
        $this->post(
            '/api/v1/discounts',
            [
                'id' => '1',
                'customer-id' => '1',
                'items' => [
                    [
                        'product-id' => 'A101',
                        'quantity' => '1',
                        'unit-price' => '9.75',
                        'total' => '9.75'
                    ],
                    [
                        'product-id' => 'A102',
                        'quantity' => '2',
                        'unit-price' => '49.50',
                        'total' => '99'
                    ]
                ],
                'total' => '103.99'
            ]
        )
            ->assertSuccessful()
            ->assertExactJson([
                'id' => (int)$orderData['id'],
                'discounts' => [],
                'items' => [
                    [
                        'discount' => [
                            'amount' => 1.95,
                            'reason' => '20% discount on the cheapest Product'
                        ],
                        'productId' => 'A101',
                        'quantity' => 1,
                        'unitPrice' => 9.75,
                        'total' => 9.75
                    ],
                    [
                        'productId' => 'A102',
                        'quantity' => 2,
                        'unitPrice' => 49.50,
                        'total' => 99
                    ]
                ],
                'total' => 108.75,
                'totalWithDiscounts' => 106.8,
            ]);
    }

    public function test_the_discount_with_3_discounts(): void
    {
        $orderData = self::order3Data();
        $this->post(
            '/api/v1/discounts',
            [
                'id' => '1',
                'customer-id' => '2',
                'items' => [
                    [
                        'product-id' => 'B101',
                        'quantity' => '5',
                        'unit-price' => '9.75',
                        'total' => '48.75'
                    ],
                    [
                        'product-id' => 'A102',
                        'quantity' => '2',
                        'unit-price' => '49.50',
                        'total' => '99'
                    ]
                ],
                'total' => '103.99'
            ]
        )
            ->assertSuccessful()
            ->assertExactJson([
                'id' => (int)$orderData['id'],
                'discounts' => [
                    [
                        'amount' => 10.4,
                        'reason' => '10% discount for customers who spent over €1000'
                    ]
                ],
                'items' => [
                    [
                        'discount' => [
                            'amount' => 0,
                            'reason' => 'Buy 5 Switches get 1 free'
                        ],
                            'productId' => 'B101',
                            'quantity' => 6,
                            'unitPrice' => 9.75,
                            'total' => 48.75
                        ],
                        [
                            'discount' => [
                                'amount' => 9.9,
                                'reason' => '20% discount on the cheapest Product'
                            ],
                            'productId' => 'A102',
                            'quantity' => 2,
                            'unitPrice' => 49.50,
                            'total' => 99
                        ]
                    ],
                    'total' => 147.75,
                    'totalWithDiscounts' => 127.45,
                ]
            );
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
