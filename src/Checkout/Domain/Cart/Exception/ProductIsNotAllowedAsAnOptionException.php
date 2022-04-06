<?php

namespace ShoppingCart\Exception\Content;

use DomainException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class ProductIsNotAllowedAsAnOptionException extends DomainException
{
    public static function fromProduct(Product $product): self
    {
        return new self(sprintf('El producto "%s" no puede ser usado como una opción de personalización.', $product->getSku()->value()));
    }
}
