<?php

namespace VS\Next\Checkout\Domain\Cart;

use InvalidArgumentException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class CartLineType
{
    public const NORMAL = 'NORMAL';
    public const RECONDITIONED = 'RECONDITIONED';
    public const GIFT_CARD = 'GIFT_CARD';
    public const CUSTOMIZED = 'CUSTOMIZED';

    public const VALUES = [
        self::NORMAL,
        self::RECONDITIONED,
        self::GIFT_CARD,
        self::CUSTOMIZED
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
        return $this->value() === self::NORMAL;
    }

    public function isReconditioned(): bool
    {
        return $this->value() == self::RECONDITIONED;
    }

    public function isGiftCard(): bool
    {
        return $this->value() === self::GIFT_CARD;
    }

    public function isCustomized(): bool
    {
        return $this->value() === self::CUSTOMIZED;
    }

    public static function createNormal(): self
    {
        return new self(self::NORMAL);
    }

    public static function createReconditioned(): self
    {
        return new self(self::RECONDITIONED);
    }

    public static function createGiftCard(): self
    {
        return new self(self::GIFT_CARD);
    }

    public static function createCustomized(): self
    {
        return new self(self::CUSTOMIZED);
    }

    public function createCartLine(Product $product, int $units = 0, bool $free = false): CartLine
    {
        if ($this->isNormal()) {
            return new NormalCartLine($product, $units, $free);
        }

        if ($this->isGiftCard()) {
            return new GiftCardCartLine($product, $units);
        }

        if ($this->isReconditioned()) {
            return new ReconditionedCartLine($product, $units);
        }

        if ($this->isCustomized()) {
            return new CustomizedCartLine($product, $units);
        }

        throw new InvalidArgumentException('The creation of lines for this type has not been implemented');
    }

    public static function fromString(string $type): self
    {
        if ($type === self::NORMAL) {
            return self::createNormal();
        }

        if ($type === self::RECONDITIONED) {
            return self::createReconditioned();
        }

        if ($type === self::CUSTOMIZED) {
            return self::createCustomized();
        }

        if ($type === self::GIFT_CARD) {
            return self::createGiftCard();
        }

        throw new InvalidArgumentException('The specified type is not valid.');
    }
}
