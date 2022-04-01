<?php

namespace VS\Next\Tests\PHPUnit\Catalog\Domain\Product;


use Ramsey\Uuid\Uuid;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\VariableProduct;

class VariableProductMother
{

    private const SKU = 'VARIABLE';

    public static function get(): VariableProduct
    {
        $variable = new VariableProduct(
            ProductIdMother::random(),
            ProductSku::fromString(SELF::SKU),
            ProductName::fromString('VARIABLE_PRODUCT')
        );

        return $variable;
    }

    public static function getInactive(): VariableProduct
    {
        return (static::get())->deactivate();
    }
}
