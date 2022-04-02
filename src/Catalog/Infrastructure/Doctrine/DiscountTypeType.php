<?php

namespace VS\Next\Catalog\Infrastructure\Doctrine;

use VS\Next\Catalog\Domain\Product\Entity\DiscountType;
use VS\Next\Shared\Infrastructure\Doctrine\EnumType;

class DiscountTypeType extends EnumType
{
    protected function typeClassName(): string
    {
        return DiscountType::class;
    }
}
