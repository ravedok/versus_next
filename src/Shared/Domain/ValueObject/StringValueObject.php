<?php

namespace VS\Next\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    final public function __construct(private string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public function __toString()
    {
        return $this->value;
    }
}
