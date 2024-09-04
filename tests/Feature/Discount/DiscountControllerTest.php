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

    public function test_the_discount_returns_correct_loyalty_discount(): void
    {
        $orderData = self::order2Data();
        $this->post(
            '/api/v1/discounts',
            $orderData
        )
            ->assertSuccessful()
            ->assertExactJson([
                'id' => (int)$orderData['id'],
                'discounts' => [
                    [
                        'amount' => 2.495,
                        'reason' => '10% discount for customers who spent over €1000'
                    ]
                ],
                'total' => 0,
                'totalWithDiscounts' => 0,
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
