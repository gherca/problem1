<?php

namespace App\Product\Application\Repositories;

use App\Product\Domain\Entities\Product;
use App\Product\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    private array $data = [
        [
            "id" => "A101",
            "description" => "Screwdriver",
            "category" => "1",
            "price" => "9.75"
        ],
        [
            "id" => "A102",
            "description" => "Electric screwdriver",
            "category" => "1",
            "price" => "49.50"
        ],
        [
            "id" => "B101",
            "description" => "Basic on-off switch",
            "category" => "2",
            "price" => "4.99"
        ],
        [
            "id" => "B102",
            "description" => "Press button",
            "category" => "2",
            "price" => "4.99"
        ],
        [
            "id" => "B103",
            "description" => "Switch with motion detector",
            "category" => "2",
            "price" => "12.95"
        ]
    ];

    public function findByCategoryId(int $id): Collection
    {
        $products = Arr::where($this->data, static function ($value) use ($id) {
            return (int)$value['category'] === $id;
        });

        return collect($products ? Product::collect($products) : []);
    }
}
