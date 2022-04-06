<?php

namespace VS\Next\Checkout\Domain\Cart\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class ProductNotAllowRencoditionedStockException extends DomainException
{
    public static function fromProduct(Product $product): self
    {
        return new self(sprintf('El producto "%s" no admite stock reacondicionado.', $product->getSku()->value()));
    }
}
