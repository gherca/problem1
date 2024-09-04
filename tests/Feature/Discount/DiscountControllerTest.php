<?php

namespace Feature\Discount;

use Tests\TestCase;

class DiscountControllerTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->post(
            '/api/v1/discounts',
            [
                'id' => '1',
                'customer-id' => '1',
                'items' => [
                    [
                        'product-id' => 'B102',
                        'quantity' => '10',
                        'unit-price' => '4.99',
                        'total' => '49.90'
                    ],
                ],
                'total' => '49.90'
            ]
        );

        $response->assertStatus(200);
    }
}
