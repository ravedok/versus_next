<?php

namespace VS\Next\Catalog\Domain\Category;

use VS\Next\Shared\Domain\ValueObject\StringValueObject;

class CategoryName extends StringValueObject
{
    public const MAX_LENGTH = 30;
    public const MIN_LENGTH = 1;

    protected function ensureIsValid(): void
    {
        $this->ensureIsTrim();
        $this->ensureValidMaxLengthIs(self::MAX_LENGTH);
        $this->ensureValidMinLengthIs(self::MIN_LENGTH);
    }
}
