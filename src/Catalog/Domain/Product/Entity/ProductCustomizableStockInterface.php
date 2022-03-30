<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use Doctrine\Common\Collections\Collection;
use VS\Next\Catalog\Domain\Product\Entity\ProductOption;

interface ProductCustomizableStockInterface
{
    public function getCustomizable(): ProductCustomizableStock;
    public function isCustomizable(): bool;
    /** @return Collection<int, ProductOption> */
    public function getOptions(): Collection;
    public function addOption(ProductOption $option): self;
    public function removeOption(ProductOption $option): self;
}
