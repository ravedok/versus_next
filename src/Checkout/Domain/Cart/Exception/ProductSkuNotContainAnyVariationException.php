<?php

namespace Versus\Checkout\ShoppingCart\Exception\Content;

use DomainException;

class ProductSkuNotContainAnyVariationException extends DomainException
{
    /** @var string */
    protected $message = 'El Sku de producto no contiene una variación.';
}
