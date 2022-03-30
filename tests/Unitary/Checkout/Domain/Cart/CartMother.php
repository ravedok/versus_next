<?php

namespace VS\Next\Tests\Unitary\Checkout\Domain\Cart;

use VS\Next\Checkout\Domain\Cart\Cart;

class CartMother
{
    public static function get(array $cartLines = [])
    {
        $cart = new Cart;

        foreach ($cartLines as $cartLine) {
            $cart->addLine($cartLine);
        }

        return $cart;
    }
}
