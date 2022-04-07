<?php

namespace VS\Next\Promotions\Domain\Profit;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Promotions\Domain\Shared\CalculatedCartDiscount;

interface CartProfitInterface
{
    public function calculateProfitToCart(Cart $cart): ?CalculatedCartDiscount;
}
