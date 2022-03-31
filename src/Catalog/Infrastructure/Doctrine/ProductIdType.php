<?php

namespace VS\Next\Catalog\Infrastructure\Doctrine;

use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Shared\Infrastructure\Doctrine\UuidType;

class ProductIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return ProductId::class;
    }
}
