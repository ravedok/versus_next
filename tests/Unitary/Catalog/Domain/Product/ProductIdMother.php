<?php

namespace VS\Next\Tests\Unitary\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\ProductId;

class ProductIdMother
{
    public static function random(): ProductId
    {
        return ProductId::fromInteger(rand(1, 9999));
    }
}
