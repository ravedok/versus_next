<?php

namespace VS\Next\Catalog\Infrastructure\Faker;

use Faker\Provider\Base;
use VS\Next\Catalog\Domain\Category\CategoryId;
use VS\Next\Catalog\Domain\Category\CategoryName;

class CategoryProvider extends Base
{
    public static function categoryId(): CategoryId
    {
        return CategoryId::random();
    }

    public static function categoryNameFromString(string $name): CategoryName
    {
        return CategoryName::fromString($name);
    }
}
