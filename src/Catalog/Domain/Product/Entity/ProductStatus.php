<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

class ProductStatus
{
    public const INACTIVE = 'INACTIVE';
    public const ACTIVE = 'ACTIVE';
    public const OBSOLETE = 'OBSOLETE';

    public const VALUES = [
        self::INACTIVE,
        self::ACTIVE,
        self::OBSOLETE
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

    public function isInactive(): bool
    {
        return $this->value == self::INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->value == self::ACTIVE;
    }
    public function isObsolete(): bool
    {
        return $this->value == self::OBSOLETE;
    }

    public static function createActive(): self
    {
        return new self(self::ACTIVE);
    }

    public static function createInactive(): self
    {
        return new self(self::INACTIVE);
    }

    public static function createObsolete(): self
    {
        return new self(self::OBSOLETE);
    }
}
