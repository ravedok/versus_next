<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

trait ProductCustomizableStockTrait
{
    private ProductCustomizableStock $customizable;
    /** @var ArrayCollection<int, ProductOption> */
    private Collection $options;

    private function customizableDefaultValues(): void
    {
        $this->customizable = new ProductCustomizableStock;
        $this->options = new ArrayCollection();
    }

    public function getCustomizable(): ProductCustomizableStock
    {
        return $this->customizable;
    }

    /** @retun Collection<int, Option> */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(ProductOption $option): self
    {
        if ($this->options->contains($option)) {
            return $this;
        }

        $option->setProductParent($this);
        $this->options->add($option);

        return $this;
    }

    public function removeOption(ProductOption $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    public function isCustomizable(): bool
    {
        return $this->getCustomizable()->isCustomizable();
    }
}
