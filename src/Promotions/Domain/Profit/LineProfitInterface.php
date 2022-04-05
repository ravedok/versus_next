<?php

namespace VS\Next\Promotions\Domain\Profit;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;

interface LineProfitInterface
{
    public function calculateProfitToCartLine(CartLine $cartLine): CalculatedLineDiscount;
}
