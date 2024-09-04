<?php

namespace Tests\Unit\Customer\Application\Repositories;

use App\Customer\Application\Exceptions\CustomerNotFoundException;
use App\Customer\Application\Repositories\CustomerRepository;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    public function test_findById_throw_exception(): void
    {
        $this->expectException(CustomerNotFoundException::class);
        (new CustomerRepository)->findById(999);
    }
}
