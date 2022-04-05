<?php

namespace VS\Next\Promotions\Domain\Shared;

use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\DiscountType;

class CalculatedDiscount
{
    public function __construct(
        private Product $product,
        private DiscountType $type,
        private float $value,
        private ?Judgment $judgment = null
    ) {
    }

    public function getProduct(): Product
    {
        return $this->product;
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
        return $this->type->calculateAmountToDiscount($this->product->getPrice(), $this->value);
    }

    public function getDiscountedPrice(): float
    {
        return $this->getProduct()->getPrice() - $this->getDiscountedAmount();
    }
}
