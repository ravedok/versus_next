<?php

namespace VS\Next\Tests\Unitary\Checkout\Domain\Cart;

use VS\Next\Checkout\Domain\Cart\CustomizedCartLine;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Tests\Unitary\Catalog\Domain\Product\ProductMother;

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
