<?php

namespace App\Customer\Application\Repositories;

use App\Customer\Application\Exceptions\CustomerNotFoundException;
use App\Customer\Domain\Entities\Customer;
use App\Customer\Domain\Repositories\CustomerRepositoryInterface;
use Illuminate\Support\Arr;

class CustomerRepository implements CustomerRepositoryInterface
{
    private array $data = [
        [
            "id" => "1",
            "name" => "Coca Cola",
            "since" => "2014-06-28",
            "revenue" => "492.12"
        ],
        [
            "id" => "2",
            "name" => "Teamleader",
            "since" => "2015-01-15",
            "revenue" => "1505.95"
        ],
        [
            "id" => "3",
            "name" => "Jeroen De Wit",
            "since" => "2016-02-11",
            "revenue" => "0.00"
        ]
    ];


    /**
     * @throws CustomerNotFoundException
     */
    public function findById(int $id): Customer
    {
        $customer = Arr::first($this->data, static function ($value, $key) use ($id) {
            return (int)$value['id'] === $id;
        });

        if ($customer === null) {
            throw new CustomerNotFoundException();
        }

        return Customer::from($customer);
    }
}
