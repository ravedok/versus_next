<?php

namespace VS\Next\Promotions\Domain\Promotion;

use VS\Next\Shared\Domain\ValueObject\StringValueObject;

class PromotionName extends StringValueObject
{
    protected function ensureIsValid(): void
    {
        $this->ensureIsTrim();
        $this->ensureValidMaxLengthIs(100);
        $this->ensureValidMinLengthIs(1);
    }
}
