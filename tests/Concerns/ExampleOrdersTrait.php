<?php

namespace Tests\Concerns;

trait ExampleOrdersTrait
{
    public static function order1Data(): array
    {
        return [
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
        ];
    }

    public static function order2Data(): array
    {
        return [
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
        ];
    }

    public static function order3Data(): array
    {
        return [
            'id' => '1',
            'customer-id' => '3',
            'items' => [
                [
                    'product-id' => 'B102',
                    'quantity' => '2',
                    'unit-price' => '9.75',
                    'total' => '19.50'
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => '1',
                    'unit-price' => '49.50',
                    'total' => '49.50'
                ]
            ],
            'total' => '69.00'
        ];
    }
}
