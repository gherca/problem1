<?php

namespace App\Common\Infrastructure\Providers;

use App\Customer\Application\Repositories\CustomerRepository;
use App\Customer\Domain\Repositories\CustomerRepositoryInterface;
use App\Discount\Application\Discounts\LoyaltyDiscount;
use App\Discount\Domain\Services\DiscountManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DiscountManager::class, function ($app) {
            return new DiscountManager([
                $app->make(LoyaltyDiscount::class)
            ]);
        });
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
    }

    public function boot(): void
    {

    }
}
