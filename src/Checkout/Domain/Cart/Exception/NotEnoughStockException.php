<?php

namespace VS\Next\Checkout\Domain\Cart\Exception;

use DomainException;
use VS\Next\Shared\Domain\Exception\DomainBadRequestException;

class NotEnoughStockException extends DomainException implements DomainBadRequestException
{
    /** @var string */
    protected $message = 'No hay suficiente stock.';
}
