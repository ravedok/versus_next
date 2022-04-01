<?php

namespace VS\Next\Tests\PHPUnit\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\ReconditionedCartLine;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;

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
