<?php

namespace VS\Next\Checkout\Application\Content\SetProduct;

use VS\Next\Checkout\Application\Content\Shared\AbstractContentRequest;

class SetProductRequest extends AbstractContentRequest
{
    /** @param int $units */
    public function __construct(protected $productSku, protected $reconditioned = false, protected $units = 1, protected array $options = [])
    {
    }

    /** @return int */
    public function getUnits()
    {
        return $this->units;
    }
}
