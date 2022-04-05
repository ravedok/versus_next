<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Promotions\Domain\Profit\Types\ProductAmountProfit;

class ProductAmountProfitMother
{
    public static function get(float $amount = null): ProductAmountProfit
    {
        return new ProductAmountProfit(
            ProfitId::random(),
            $amount ?: 10
        );
    }
}
