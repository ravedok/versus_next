<?php

namespace VS\Next\Tests\PHPUnit\Checkout\Domain\Cart;

use VS\Next\Checkout\Domain\Cart\CustomizedCartLine;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Tests\PHPUnit\Catalog\Domain\Product\ProductMother;

class CustomizedCartLineMother
{
    /** @param CartLineOption[] $options */
    public static function get(
        ?Product $product = null,
        ?int $units = 1,
        array $options = []

    ): CustomizedCartLine {
        $cartLine = new CustomizedCartLine(
            $product ?? ProductMother::getCustomizable(),
            $units
        );

        foreach ($options as $option) {
            $cartLine->addOption($option);
        }

        return $cartLine;
    }
}
