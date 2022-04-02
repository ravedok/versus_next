<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

interface ProductOfferableInterface
{
    public function getOffer(): ProductOffer;

    public function setOffer(ProductOffer $offer): self;
}
