<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use VS\Next\Checkout\Application\Content\Shared\DestinationService;

trait VatCalculatorTrait
{
    private DestinationService $destination;

    public function addVat(float $amount): float
    {
        return $amount * (1 + $this->destination->getVat() / 100);
    }

    public function currencyWithVat(float $amount): float
    {
        return round($this->addVat($amount), 2);
    }
}
