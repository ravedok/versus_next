<?php

namespace VS\Next\Catalog\Domain\Product;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\VariationProduct;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductType;
use ShoppingCart\Exception\Content\ProductIsNotAllowedAsAnOptionException;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Entity\ProductSku;
use VS\Next\Catalog\Domain\Product\Exception\ProductVariationUnspecifiedException;

class VariableProduct extends Product
{
    /** @var ArrayCollection<int, VariationProduct> */
    private Collection $variations;

    public function __construct(ProductId $id, ProductSku $sku, ProductName $name)
    {
        parent::__construct($id, $sku, $name);
        $this->type = ProductType::createVariable();
        $this->variations = new ArrayCollection;
    }

    public function getPrice(): float
    {
        return array_reduce($this->variations->toArray(), function (float $carry, VariationProduct $variation) {
            if ($carry == 0 || $carry > $variation->getPrice()) {
                $carry = $variation->getPrice();
            }

            return $carry;
        }, 0);
    }

    public function getAvailableStock(): int
    {
        return 0;
    }

    public function isStockable(): bool
    {
        return false;
    }

    /** @return Collection<int, VariationProduct> */
    public function getVariations(): Collection
    {
        return $this->variations;
    }

    public function getVariationFromSku(string $sku): VariationProduct | false
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('sku', $sku));

        return $this->variations->matching($criteria)->first();
    }

    public function ensureIsForDirectSale(): void
    {
        throw ProductVariationUnspecifiedException::formProduct($this);
    }

    public function ensureIsAllowedAsAnOption(): void
    {
        throw ProductIsNotAllowedAsAnOptionException::fromProduct($this);
    }
}
