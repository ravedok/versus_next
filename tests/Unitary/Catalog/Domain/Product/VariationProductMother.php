<?php

namespace VS\Next\Tests\Unitary\Catalog\Domain\Product;

use Ramsey\Uuid\Uuid;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\VariableProduct;
use VS\Next\Catalog\Domain\Product\VariationProduct;
use VS\Next\Tests\Unitary\Catalog\Domain\Product\VariableProductMother;

class VariationProductMother
{
    public const SKU = 'VARIABLE##XXL';

    public static function get(VariableProduct $parent = null): VariationProduct
    {
        if ($parent === null) {
            $parent = VariableProductMother::get();
        }
        return new VariationProduct(
            ProductId::random(),
            ProductSku::fromString(self::SKU),
            ProductName::fromString('VARIABLE XXL'),
            $parent
        );
    }

    public static function getInactive(VariableProduct $parent = null): VariationProduct
    {
        return (self::get())->deactivate();
    }
}
