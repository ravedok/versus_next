<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Promotions\Domain\Profit\Types\CheapestProductPercentDiscountProfit;

class CheapestProductPercentDiscountProfitMother
{
    public static function get(float $percent = 50, int $unitsNeeded = 2): CheapestProductPercentDiscountProfit
    {
        return new CheapestProductPercentDiscountProfit(
            ProfitId::random(),
            $percent,
            $unitsNeeded
        );
    }
}
