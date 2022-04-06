<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Promotions\Domain\Profit\Types\CartPercentDiscountProfit;

class CartPercentDiscountProfitMother
{
    public static function get(float $percent): CartPercentDiscountProfit
    {
        return new CartPercentDiscountProfit(ProfitId::random(), $percent);
    }
}
