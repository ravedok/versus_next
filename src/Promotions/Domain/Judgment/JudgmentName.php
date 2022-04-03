<?php

namespace VS\Next\Promotions\Domain\Judgment;

use VS\Next\Shared\Domain\ValueObject\StringValueObject;

class JudgmentName extends StringValueObject
{
    protected function ensureIsValid(): void
    {
        $this->ensureIsTrim();
        $this->ensureValidMaxLengthIs(100);
        $this->ensureValidMinLengthIs(1);
    }
}
