<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class ProductVariableCannotBeAnProductOptionException extends DomainException
{
    public static function fromProduct(Product $product): self
    {
        return new self(sprintf('Un producto variable "%s" no puede ser una opción de un producto.', $product->getSku()->value()));
    }
}
