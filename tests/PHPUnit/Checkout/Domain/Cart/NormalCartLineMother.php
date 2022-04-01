<?php

namespace VS\Next\Tests\PHPUnit\Checkout\Domain\Cart;

use VS\Next\Checkout\Domain\Cart\NormalCartLine;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;

class NormalCartLineMother
{
    public static function get(
        ?Product $product = null,
        ?int $units = 1

    ): NormalCartLine {
        return new NormalCartLine(
            $product ?? ProductMother::get(),
            $units
        );
    }
}
