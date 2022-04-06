<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Promotions\Domain\Profit\Types\CartAmountDiscountProfit;

class CartAmountDiscountProfitMother
{
    public static function get(?float $amount = null): CartAmountDiscountProfit
    {
        return new CartAmountDiscountProfit(ProfitId::random(), $amount ?: 10);
    }
}
