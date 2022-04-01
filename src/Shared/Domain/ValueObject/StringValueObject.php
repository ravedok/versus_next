<?php

namespace VS\Next\Shared\Domain\ValueObject;

use Doctrine\Common\Collections\Expr\Value;
use InvalidArgumentException;

abstract class StringValueObject
{
    protected string $value;

    final public function __construct(string $value)
    {
        $this->value = $value;
        $this->ensureIsValid();
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

    abstract protected function ensureIsValid(): void;



    protected function ensureValidMaxLengthIs(int $maxLength): void
    {
        $value = $this->value;

        if (strlen($value) > $maxLength) {
            throw new InvalidArgumentException(sprintf('"%s" does not allow the value "%s" because it has a length greater than <%d>.', static::class, $value, $maxLength));
        }
    }

    protected function ensureValidMinLengthIs(int $minLenght): void
    {
        $value = $this->value;

        if (strlen($value) < $minLenght) {
            throw new InvalidArgumentException(sprintf('"%s" does not allow the value "%s" because it has a length lower than <%d>.', static::class, $value, $minLenght));
        }
    }

    protected function ensureIsTrim(): void
    {
        $this->value = trim($this->value());
    }
}
