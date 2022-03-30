<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\VariationProduct;

class ProductVariationParentIsNotActiveException extends DomainException
{
    /** @var string */
    protected $message = 'La variación no está activa.';

    public static function fromProduct(VariationProduct $variationProduct): self
    {
        return new self(sprintf('El producto "%s" no está activo.', $variationProduct->getParent()->getSku()));
    }
}
