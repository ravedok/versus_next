<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

class ProductId
{
    public function __construct(private int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public static function fromInteger(int $value): self
    {
        return new self($value);
    }

    public function equals(ProductId $other): bool
    {
        return $this->value === $other->value();
    }
}
