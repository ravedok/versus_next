<?php

namespace VS\Next\Checkout\Domain\Cart\Exception;

use DomainException;

class ProductSkuNotContainAnyVariationException extends DomainException
{
    /** @var string */
    protected $message = 'El Sku de producto no contiene una variación.';
}
