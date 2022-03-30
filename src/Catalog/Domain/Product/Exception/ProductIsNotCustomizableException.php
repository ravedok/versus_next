<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class ProductIsNotCustomizableException extends DomainException
{
    public static function fromProduct(Product $product): self
    {
        return new self(sprintf('El producto "%s" no es personalizable.', $product->getSku()));
    }
}
