<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use VS\Next\Shared\Domain\ValueObject\StringValueObject;

final class ProductName extends StringValueObject
{
    public const MAX_LENGTH = 100;
    public const MIN_LENGTH = 1;

    protected function ensureIsValid(): void
    {
        $this->ensureIsTrim();
        $this->ensureValidMaxLengthIs(self::MAX_LENGTH);
        $this->ensureValidMinLengthIs(self::MIN_LENGTH);
    }
}
