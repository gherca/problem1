<?php

namespace App\Customer\Domain\Repositories;

use App\Customer\Domain\Entities\Customer;

interface CustomerRepositoryInterface
{
    public function findById(int $id): Customer;
}
