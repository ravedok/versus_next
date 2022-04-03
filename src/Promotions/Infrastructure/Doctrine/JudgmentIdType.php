<?php

namespace VS\Next\Promotions\Infrastructure\Doctrine;

use VS\Next\Promotions\Domain\Judgment\JudgmentId;
use VS\Next\Shared\Infrastructure\Doctrine\UuidType;

class JudgmentIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return JudgmentId::class;
    }
}
