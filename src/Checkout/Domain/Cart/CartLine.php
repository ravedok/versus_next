<?php

namespace VS\Next\Checkout\Domain\Cart;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Checkout\Domain\Cart\Exception\NotEnoughStockException;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;

abstract class CartLine
{
    private Cart $cart;
    protected CartLineType $type;
    protected Product $product;
    private int $units = 0;
    protected ?CalculatedLineDiscount $appliedDiscount = null;

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

        if ($this->units <= 0) {
            return $this->removeMe();
        }

        return $this;
    }

    public function addUnits(int $units): self
    {
        $this->setUnits($this->units + $units);

        return $this;
    }

    public function reduceUnits(int $units): self
    {
        $this->setUnits($this->units - $units);

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

    public function removeMe(): self
    {
        $cart = $this->getCart();
        $cart->removeLine($this);

        return $this;
    }

    public function getPrice(): float
    {
        if ($discount = $this->getAppliedDiscount()) {
            return $discount->getDiscountedPrice();
        }

        return $this->getProduct()->getPrice();
    }

    public function setAppliedDiscount(?CalculatedLineDiscount $calculatedDiscount): self
    {
        $this->appliedDiscount = $calculatedDiscount;

        return $this;
    }


    public function getAppliedDiscount(): ?CalculatedLineDiscount
    {
        return $this->appliedDiscount;
    }

    public function getTotal(): float
    {
        return $this->getUnits() * $this->getPrice();
    }
}
