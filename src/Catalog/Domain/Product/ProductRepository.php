<?php

namespace VS\Next\Catalog\Domain\Product;

use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;

interface ProductRepository
{
    public function findOneById(ProductId $id): ?Product;
    public function findOneBySku(string $sku): ?Product;
    public function findOneBySkuOrFail(string $sku): Product;
}
