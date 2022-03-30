<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

interface ProductStockableInterface
{
    public function setStockable(bool $stockable): self;
}
