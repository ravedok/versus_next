<?php

namespace VS\Next\Catalog\Domain\Product\Exception;

use DomainException;

class ProductNotFoundException extends DomainException
{
    /** @var string */
    protected $message = 'El producto solicitado no existe.';

    public function __construct(string $message = 'El producto solicitado no existe.')
    {
        parent::__construct($message);
    }

    public static function fromSku(string $sku): self
    {
        return new self("El producto con sku '$sku' no existe.");
    }
}
