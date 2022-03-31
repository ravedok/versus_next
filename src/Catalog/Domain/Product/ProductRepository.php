<?php

namespace VS\Next\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;

interface ProductRepository
{
    public function findOneById(ProductId $id): ?Product;
    public function findOneBySku(ProductSku $sku): ?Product;
    public function findOneBySkuOrFail(ProductSku $sku): Product;
}
