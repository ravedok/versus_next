<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class ProductIsNotActiveException extends DomainException
{
    public static function fromProduct(Product $product): self
    {
        return new self(sprintf('El producto con sku "%s" no está activo.', $product->getSku()->value()));
    }
}
