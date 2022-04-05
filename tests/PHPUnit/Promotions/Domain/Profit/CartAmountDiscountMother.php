<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Promotions\Domain\Profit\Types\CartAmountDiscountProfit;

class CartAmountDiscountMother
{
    public static function get(): CartAmountDiscountProfit
    {
        return new CartAmountDiscountProfit(ProfitId::random(), 10);
    }
}
