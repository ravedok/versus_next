<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Shared;

class CartLineOptionDto
{
    /**
     * @param string $productSku
     * @param string $type
     * @param int $units
     */
    public function __construct(private $productSku, private $type = null, private $units = 1)
    {
    }

    public function getProductSku(): string
    {
        return $this->productSku;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getUnits(): int
    {
        return $this->units;
    }
}
