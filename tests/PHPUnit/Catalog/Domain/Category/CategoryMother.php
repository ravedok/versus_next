<?php

namespace VS\Next\Tests\PHPUnit\Catalog\Domain\Category;

use VS\Next\Catalog\Domain\Category\Category;
use VS\Next\Catalog\Domain\Category\CategoryId;
use VS\Next\Catalog\Domain\Category\CategoryName;

class CategoryMother
{

    public static function get(): Category
    {
        return (new Category(
            CategoryId::random(),
            CategoryName::fromString('Categoría')
        ));
    }
}
