<?php

namespace App\Discount\Infrastructure\Http\Controllers;

use App\Common\Infrastructure\Http\Controllers\Controller;
use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Application\Services\DiscountService;
use Illuminate\Http\Response;

class DiscountController extends Controller
{
    public function __construct(
        private readonly DiscountService $discountService
    ) {}

    public function __invoke(
        RequestOrderDiscountData $discountData
    ): Response {
        return response($this->discountService->getDiscounts($discountData)->toArray());
    }
}
