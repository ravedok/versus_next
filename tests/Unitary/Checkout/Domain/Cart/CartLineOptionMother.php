<?php

namespace VS\Next\Tests\Unitary\Checkout\Domain\Cart;

use VS\Next\Checkout\Domain\Cart\CartLineOption;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Tests\Unitary\Catalog\Domain\Product\ProductMother;

class CartLineOptionMother
{
    public static function get(
        ?Product $product = null,
        ?string $type = null,
        int $units = 1

    ): CartLineOption {
        return new CartLineOption(
            $product ?? ProductMother::get(),
            $type,
            $units
        );
    }
}
