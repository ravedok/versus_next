<?php

namespace VS\Next\Promotions\Domain\Shared;

use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Checkout\Domain\Cart\CartLine;

class CalculatedLineDiscount
{
    public function __construct(
        private CartLine $cartLine,
        private DiscountType $type,
        private float $value,
        private int $units,
        private ?Judgment $judgment = null
    ) {
    }

    public function getCartLine(): CartLine
    {
        return $this->cartLine;
    }

    public function getProduct(): Product
    {
        return $this->getCartLine()->getProduct();
    }

    public function getType(): DiscountType
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getUnits(): int
    {
        return $this->units;
    }

    public function getJudgment(): ?Judgment
    {
        return $this->judgment;
    }

    public function getDiscountedAmount(): float
    {
        return $this->type->calculateAmountToDiscount($this->getProduct()->getPrice(), $this->value);
    }

    public function getDiscountedPrice(): float
    {
        return $this->getProduct()->getPrice() - $this->getDiscountedAmount();
    }
}
