<?php

namespace VS\Next\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;

class GiftCardCartLine extends CartLine
{
    public function __construct(Product $product, int $units = 0)
    {
        $this->type = CartLineType::createGiftCard();
        parent::__construct($product, $units);
    }

    public function maxUnits(): ?int
    {
        return null;
    }

    public function similar(CartLine $otherLine): bool
    {
        return false;
    }
}
