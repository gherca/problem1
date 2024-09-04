<?php

namespace Tests\Unit\Discount\Application;

use App\Discount\Application\DTO\RequestOrderDiscountData;
use App\Discount\Application\Services\DiscountService;
use App\Discount\Domain\Services\DiscountManager;
use Tests\Concerns\ExampleOrdersTrait;
use Tests\TestCase;

class DiscountServiceTest extends TestCase
{
    use ExampleOrdersTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDiscountManager = $this->createMock(DiscountManager::class);
        $this->discountService = new DiscountService($this->mockDiscountManager);
    }

    public function test_get_discounts_return_them_same_id(): void
    {
        $this->mockDiscountManager->expects($this->once())->method('applyDiscounts')->willReturn(collect());
        $this->assertEquals(
            self::order1Data()['id'],
            $this->discountService->getDiscounts(RequestOrderDiscountData::from(self::order1Data()))->id
        );
    }
}
