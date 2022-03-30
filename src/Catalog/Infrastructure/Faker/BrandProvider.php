<?php

namespace VS\Next\Catalog\Infrastructure\Faker;

use Faker\Provider\Base;
use VS\Next\Catalog\Domain\Brand\BrandId;
use VS\Next\Catalog\Domain\Brand\BrandName;

class BrandProvider extends Base
{
    public static function brandId(): BrandId
    {
        return BrandId::random();
    }

    public static function brandNameFromString(string $name): BrandName
    {
        return BrandName::fromString($name);
    }
}
