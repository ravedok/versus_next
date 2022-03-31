<?php

namespace VS\Next\Checkout\Application\Content\Shared;

use VS\Next\Checkout\Infrastructure\Controller\Shared\CartLineOptionDto;

abstract class AbstractContentRequest
{
    public string $productSku;
    public bool $isReconditioned = false;
    /** @var CartLineOptionDto[] $options */
    public array $options = [];
}
