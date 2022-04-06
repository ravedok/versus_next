<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\VariableProduct;

class ProductVariationUnspecifiedException extends DomainException
{
    public static function formProduct(VariableProduct $product): self
    {
        return new self(sprintf('Debes especificar una variación para "%s"', $product->getSku()->value()));
    }
}
