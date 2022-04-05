<?php

namespace VS\Next\Catalog\Infrastructure\Doctrine;

use VS\Next\Catalog\Domain\Category\CategoryId;
use VS\Next\Shared\Infrastructure\Doctrine\UuidType;

class CategoryIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return CategoryId::class;
    }
}
