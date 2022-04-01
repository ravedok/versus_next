<?php

namespace VS\Next\Tests\PHPUnit\Catalog\Domain\Product;


use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Nonstandard\Uuid;
use VS\Next\Catalog\Domain\Product\NormalProduct;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;

class ProductMother
{
    private const NORMAL_ID = '9f7c9e05-82a8-4594-aa4e-7cbc14a3e7a9';
    public const NORMAL_SKU = 'NORMAL';
    public const VARIABLE_SKU = 'VARIABLE##XL';

    public static function get(?string $id = null, ?string $sku = self::NORMAL_SKU): NormalProduct
    {
        $productId = $id === null ? ProductId::random() : ProductId::fromString($id);
        if ($id === null) {
        }

        $product =  (new NormalProduct(
            $productId,
            ProductSku::fromString($sku),
            ProductName::fromString('SIMPLE PRODUCT')
        ));

        $product->getStored()->setStock(5);
        $product->getReconditioned()->setStock(2);
        // $product->getCustomizable()->setCustomizable(true);

        return $product;
    }

    public static function getInactive(): Product
    {
        return (static::get())->deactivate();
    }

    public static function getNotSallable(): Product
    {
        return (static::get())->setAllowDirectSale(false);
    }

    public static function getCustomizable(): NormalProduct
    {
        $product = static::get();
        $product->getCustomizable()->setCustomizable(true);

        return $product;
    }
}
