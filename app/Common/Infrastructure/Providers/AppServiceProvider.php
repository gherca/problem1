<?php

namespace App\Common\Infrastructure\Providers;

use App\Customer\Application\Repositories\CustomerRepository;
use App\Customer\Domain\Repositories\CustomerRepositoryInterface;
use App\Discount\Application\Discounts\BuyFiveGetOneFreeDiscount;
use App\Discount\Application\Discounts\BuyMinimTwoOfCategoryGet20PercentDiscount;
use App\Discount\Application\Discounts\LoyaltyDiscount;
use App\Discount\Domain\Services\DiscountManager;
use App\Product\Application\Repositories\ProductRepository;
use App\Product\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DiscountManager::class, function ($app) {
            return new DiscountManager([
                $app->make(LoyaltyDiscount::class),
                $app->make(BuyFiveGetOneFreeDiscount::class),
                $app->make(BuyMinimTwoOfCategoryGet20PercentDiscount::class),
            ]);
        });
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    public function boot(): void
    {

    }
}
