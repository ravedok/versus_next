<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use VS\Next\Catalog\Domain\Product\Entity\ProductOffer;

trait ProductOfferableTrait
{
    private ProductOffer $offer;

    private function offerableDefaultValues(): void
    {
        $this->offer = new ProductOffer();
    }

    public function getOffer(): ProductOffer
    {
        return $this->offer;
    }

    public function setOffer(ProductOffer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function isOfferable(): bool
    {
        return true;
    }
}
