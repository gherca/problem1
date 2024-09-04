<?php

namespace App\Common\Infrastructure\Providers;

use App\Discount\Domain\Services\DiscountManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DiscountManager::class, function ($app) {
            return new DiscountManager([]);
        });
    }

    public function boot(): void
    {

    }
}
