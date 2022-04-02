<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use DateTime;

class ProductOffer
{
    private DiscountType $type;

    public function __construct(
        private bool $active = false,
        private float $price = 0,
        ?DiscountType $type = null,
        private ?DateTime $start = null,
        private ?DateTime $end = null
    ) {
        $this->type = $type ?: DiscountType::createPercent();
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getType(): DiscountType
    {
        return $this->type;
    }

    public function getStart(): ?DateTime
    {
        return $this->start;
    }

    public function getEnd(): ?DateTime
    {
        return $this->end;
    }

    public function isApplicable(): bool
    {
        if ($this->active === false) {
            return false;
        }

        $now = new \DateTime();

        if ($this->start !== null && $this->start < $now) {
            return false;
        }

        if ($this->end !== null && $this->end > $now) {
            return false;
        }

        return true;
    }
}
