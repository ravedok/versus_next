<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use VS\Next\Promotions\Domain\Shared\DiscountHelper;

class DiscountType
{
    public const PERCENT = 'PERCENT';
    public const AMOUNT = 'AMOUNT';

    public const VALUES = [
        self::PERCENT,
        self::AMOUNT
    ];

    public function __construct(private string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    /** @return string[] */
    public static function values(): array
    {
        return self::values();
    }

    public function isPercent(): bool
    {
        return $this->value === self::PERCENT;
    }

    public function isAmount(): bool
    {
        return $this->value === self::AMOUNT;
    }

    public static function createPercent(): self
    {
        return new self(self::PERCENT);
    }

    public static function createAmount(): self
    {
        return new self(self::AMOUNT);
    }

    public function calculateAmountToDiscount(float $price, float $value): float
    {
        if ($this->isAmount()) {
            return $value;
        }

        return DiscountHelper::calculateDiscountedAmount($price, $value);
    }
}
