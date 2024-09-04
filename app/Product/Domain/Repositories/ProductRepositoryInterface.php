<?php

namespace App\Product\Domain\Repositories;

use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function findByCategoryId(int $id): Collection;
}
