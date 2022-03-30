<?php

namespace VS\Next\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\RedeemableProduct;

class RedeemableCartLine extends CartLine
{
    /** @var RedeemableProduct $product */
    protected Product $product;

    public function __construct(RedeemableProduct $product, int $units = 0)
    {
        parent::__construct($product, $units);
    }

    /** @return RedeemableProduct */
    public function getProduct(): Product
    {
        return $this->product;
    }

    public function similar(CartLine $otherLine): bool
    {
        if (!$otherLine instanceof RedeemableCartLine) {
            return false;
        }

        return $this->getProduct() === $otherLine->getProduct();
    }

    public function maxUnits(): ?int
    {
        $availableStock = $this->getProduct()->getRedeemable()->getStock();

        foreach ($this->getCart()->getLines() as $line) {
            if (!$line instanceof RedeemableCartLine) {
                continue;
            }

            if ($this === $line) {
                continue;
            }

            if ($this->getProduct() !== $line->getProduct()) {
                continue;
            }

            $availableStock -= $line->getUnits();
        }

        return $availableStock;
    }
}
