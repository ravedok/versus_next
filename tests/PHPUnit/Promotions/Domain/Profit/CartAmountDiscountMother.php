<?php

namespace VS\Next\Tests\PHPUnit\Promotions\Domain\Profit;

use VS\Next\Promotions\Domain\Profit\Types\CartAmountDiscount;

class CartAmountDiscountMother
{
    public static function get(): CartAmountDiscount
    {
        return new CartAmountDiscount();
    }
}
