<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class ProductNotAllowDirectSalesException extends DomainException
{
    public static function fromProduct(Product $product): self
    {
        return new self(sprintf('El producto con sku "%s" no permite venta directa.', $product->getSku()->value()));
    }
}
