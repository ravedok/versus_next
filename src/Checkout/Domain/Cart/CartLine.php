<?php

namespace VS\Next\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\Exception\NotEnoughStockException;

abstract class CartLine
{
    private Cart $cart;
    protected CartLineType $type;
    protected Product $product;
    private int $units = 0;

    public function __construct(
        Product $product,
        int $units = 0
    ) {
        $this->product = $product;
        $this->units = $units;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getUnits(): int
    {
        return $this->units;
    }

    public function setUnits(int $units): self
    {
        $this->units = $units;

        return $this;
    }

    public function addUnits(int $units): self
    {
        $this->units += $units;

        return $this;
    }

    public function reduceUnits(int $units): self
    {
        $this->units -= $units;

        return $this;
    }

    public function getType(): CartLineType
    {
        return $this->type;
    }

    abstract public function similar(CartLine $otherLine): bool;
    abstract protected function maxUnits(): ?int;

    public function ensureHasEnoughtStock(int $units): void
    {
        if (!$this->getProduct()->isStockable()) {
            return;
        }

        $maxUnits = $this->maxUnits();

        if ($units > $maxUnits) {
            throw new NotEnoughStockException;
        }
    }
}
