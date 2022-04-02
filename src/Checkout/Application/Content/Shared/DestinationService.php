<?php

namespace VS\Next\Checkout\Application\Content\Shared;

class DestinationService
{
    public const VAT = 21;

    public function getVat(): int
    {
        return self::VAT;
    }
}
