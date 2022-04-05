<?php

namespace VS\Next\Promotions\Domain\Shared;

use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Checkout\Domain\Cart\Cart;

class CalculatedCartDiscount
{
    public function __construct(
        private Cart $cart,
        private DiscountType $type,
        private float $value,
        private ?Judgment $judgment = null
    ) {
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getType(): DiscountType
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getJudgment(): ?Judgment
    {
        return $this->judgment;
    }

    public function getDiscountedAmount(): float
    {
        return $this->type->calculateAmountToDiscount($this->getCart()->getTotalLines(), $this->value);
    }

    public function getDiscountedTotal(): float
    {
        return $this->getCart()->getTotalLines() - $this->getDiscountedAmount();
    }
}
