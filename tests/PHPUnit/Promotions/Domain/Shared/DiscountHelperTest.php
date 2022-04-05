<?php

namespace VS\Next\PHPUnit\Promotions\Domain\Shared;

use PHPUnit\Framework\TestCase;
use VS\Next\Promotions\Domain\Shared\DiscountHelper;

class DiscountHelperTest extends TestCase
{
    public function test_if_calculate_discount_percent_correctly(): void
    {
        $percent = DiscountHelper::calculateDiscountPercent(142.10, 139.45);
        $this->assertEquals(1.8649, $percent);
    }

    public function test_if_calculate_discounted_amount_correctly(): void
    {
        $amount = DiscountHelper::calculateDiscountedAmount(142.10, 1.8649);
        $this->assertEquals(2.65, $amount);
    }
}
