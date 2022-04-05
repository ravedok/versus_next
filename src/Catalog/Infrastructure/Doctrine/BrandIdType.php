<?php

namespace VS\Next\Catalog\Infrastructure\Doctrine;

use VS\Next\Catalog\Domain\Brand\BrandId;
use VS\Next\Shared\Infrastructure\Doctrine\UuidType;

class BrandIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return BrandId::class;
    }
}
