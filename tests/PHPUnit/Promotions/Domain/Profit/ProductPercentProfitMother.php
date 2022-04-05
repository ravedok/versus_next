<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\Types\ProductPercentProfit;
use VS\Next\Promotions\Domain\Profit\ProfitId;

class ProductPercentProfitMother
{

    public static function get(float $percent = null): ProductPercentProfit
    {
        return new ProductPercentProfit(
            ProfitId::random(),
            $percent ?: self::randomPercent()
        );
    }

    public static function randomPercent(): float
    {
        return rand(1, 10000) / 100;
    }
}
