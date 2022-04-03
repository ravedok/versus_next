<?php

namespace VS\Next\Promotions\Infrastructure\Doctrine;

use VS\Next\Promotions\Domain\Profit\ProfitId;
use VS\Next\Shared\Infrastructure\Doctrine\UuidType;

class ProfitIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ProfitId::class;
    }
}
