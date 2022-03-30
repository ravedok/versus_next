<?php

namespace Versus\Checkout\ShoppingCart\Exception\Content;

use DomainException;

class NotEnoughStockException extends DomainException
{
    /** @var string */
    protected $message = 'No hay suficiente stock.';
}
