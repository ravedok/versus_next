<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

class ProductType
{
    public const NORMAL = 'NORMAL';
    public const VARIABLE = 'VARIABLE';
    public const VARIATION = 'VARIATION';
    public const GIFT_CARD = 'GIFT_CARD';
    public const REDEEMABLE = 'REDEEMABLE';

    public const VALUES = [
        self::NORMAL,
        self::VARIABLE,
        self::VARIATION,
        self::GIFT_CARD,
        self::REDEEMABLE,
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

    public function isNormal(): bool
    {
        return $this->value == self::NORMAL;
    }

    public function isVariable(): bool
    {
        return $this->value == self::VARIABLE;
    }

    public function isVariation(): bool
    {
        return $this->value == self::VARIATION;
    }

    public function isGiftCard(): bool
    {
        return $this->value == self::GIFT_CARD;
    }

    public function isRedeemable(): bool
    {
        return $this->value == self::REDEEMABLE;
    }

    public static function createNormal(): self
    {
        return new self(self::NORMAL);
    }

    public static function createVariable(): self
    {
        return new self(self::VARIABLE);
    }

    public static function createVariation(): self
    {
        return new self(self::VARIATION);
    }

    public static function createGiftCard(): self
    {
        return new self(self::GIFT_CARD);
    }

    public static function createRedeemable(): self
    {
        return new self(self::REDEEMABLE);
    }
}
