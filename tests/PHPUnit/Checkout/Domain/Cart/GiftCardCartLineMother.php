<?php

namespace VS\Next\Tests\PHPUnit\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\GiftCardCartLine;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;

class GiftCardCartLineMother
{
    public static function get(
        ?Product $product = null,
        ?int $units = 1

    ): GiftCardCartLine {
        return new GiftCardCartLine(
            $product ?? ProductMother::get(),
            $units
        );
    }
}
