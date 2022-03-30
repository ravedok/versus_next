<?php

namespace VS\Next\Checkout\Application\Content\Shared;

use VS\Next\Checkout\Infrastructure\Controller\Shared\CartLineOptionDto;

abstract class AbstractContentRequest
{    
    /**
     * @param string $productSku 
     * @param bool $reconditioned 
     * @param CartLineOptionDto[] $options 
     */
    public function __construct(protected $productSku, protected $reconditioned = false, protected array $options = [])
    {
    }

    /** @return string */
    public function getProductSku()
    {
        return $this->productSku;
    }

    /** @return CartLineOptionDto[] */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function isReconditioned(): bool
    {
        return $this->reconditioned;
    }
}
