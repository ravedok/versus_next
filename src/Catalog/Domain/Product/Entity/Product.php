<?php

namespace VS\Next\Catalog\Domain\Product\Entity;

use VS\Next\Catalog\Domain\Brand\Brand;
use Doctrine\Common\Collections\Collection;
use VS\Next\Catalog\Domain\Category\Category;
use Doctrine\Common\Collections\ArrayCollection;
use VS\Next\Catalog\Domain\Product\Entity\ProductName;
use VS\Next\Catalog\Domain\Product\Entity\ProductId;
use VS\Next\Catalog\Domain\Product\Exception\ProductIsNotActiveException;
use VS\Next\Catalog\Domain\Product\Exception\ProductNotAllowDirectSalesException;

abstract class Product
{
    private ProductId $id;
    protected ProductType $type;
    private ProductSku $sku;
    private ProductStatus $status;
    private ProductName $name;
    private ?Category $category;
    /** @var ArrayCollection<int, Brand> */
    private Collection $brands;
    protected bool $stockable = true;
    private bool $allowDirectSales;
    private bool $allowPromotions;

    // TODO Configuración (¿personalizaciones?)
    // TODO Tarjetas regalo
    // TODO Portes
    // TODO Canon
    // TODO Garantias
    // TODO Precios/Ofertas
    // TODO Bonus
    // TODO Reservas

    public function __construct(ProductId $id, ProductSku $sku, ProductName $name)
    {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->status = ProductStatus::createActive();
        $this->brands = new ArrayCollection;
        $this->stockable = true;
        $this->allowDirectSales = true;
        $this->allowPromotions = true;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getSku(): ProductSku
    {
        return $this->sku;
    }

    public function setSku(ProductSku $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getStatus(): ProductStatus
    {
        return $this->status;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function setName(ProductName $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /** @return Collection<int, Brand> */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand): self
    {
        if ($this->brands->contains($brand)) {
            return $this;
        }

        $this->brands->add($brand);

        return $this;
    }

    public function removeBrand(Brand $brand): self
    {
        $this->brands->removeElement($brand);

        return $this;
    }

    public function allowDirectSale(): bool
    {
        return $this->allowDirectSales;
    }

    public function setAllowDirectSale(bool $salable): self
    {
        $this->allowDirectSales = $salable;

        return $this;
    }

    public function isAllowPromotions(): bool
    {
        return $this->allowPromotions;
    }

    public function setAllowPromotions(bool $allowPromotions): self
    {
        $this->allowPromotions = $allowPromotions;

        return $this;
    }

    public function activate(): self
    {
        $this->status = ProductStatus::createActive();

        return $this;
    }

    public function deactivate(): self
    {
        $this->status = ProductStatus::createInactive();

        return $this;
    }

    public function discontinue(): self
    {
        $this->status = ProductStatus::createObsolete();

        return $this;
    }

    abstract public function getAvailableStock(): int;

    public function getType(): ProductType
    {
        return $this->type;
    }

    public function isStockable(): bool
    {
        return $this->stockable;
    }

    public function ensureIsForDirectSale(): void
    {
        if (!$this->getStatus()->isActive()) {
            throw ProductIsNotActiveException::fromProduct($this);
        }

        if (!$this->allowDirectSale()) {
            throw ProductNotAllowDirectSalesException::fromProduct($this);
        }
    }

    public function ensureIsAllowedAsAnOption(): void
    {
        if (!$this->getStatus()->isActive()) {
            throw ProductIsNotActiveException::fromProduct($this);
        }
    }

    abstract public function getPrice(): float;
}
