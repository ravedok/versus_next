<?php

namespace VS\Next\Tests\PHPUnit\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\ProductId;

class ProductIdMother
{
    public static function random(): ProductId
    {
        return ProductId::random();
    }
}
