<?php

namespace VS\Next\Promotions\Infrastructure\Doctrine;

use VS\Next\Promotions\Domain\Promotion\PromotionId;
use VS\Next\Shared\Infrastructure\Doctrine\UuidType;

class PromotionIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return PromotionId::class;
    }
}
