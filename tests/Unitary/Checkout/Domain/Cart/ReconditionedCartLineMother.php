<?php

namespace VS\Next\Tests\Unitary\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\ReconditionedCartLine;
use VS\Next\Tests\Unitary\Catalog\Domain\Product\ProductMother;

class ReconditionedCartLineMother
{
    public static function get(
        ?Product $product = null,
        ?int $units = 1

    ): ReconditionedCartLine {
        return new ReconditionedCartLine(
            $product ?? ProductMother::get(),
            $units
        );
    }
}
