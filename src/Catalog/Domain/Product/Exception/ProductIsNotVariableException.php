<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;
use VS\Next\Catalog\Domain\Product\Entity\Product;

class ProductIsNotVariableException extends DomainException
{
    /** @var string */
    protected $message = 'El producto no es variable';

    public function __construct(Product $product)
    {
        $sku = $product->getSku()->value();
        parent::__construct(sprintf("El producto con sku '%s' no es variable.", $sku));
    }
}
