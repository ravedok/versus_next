<?php

namespace VS\Next\Promotions\Domain\Judgment;

use InvalidArgumentException;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Catalog\Domain\Brand\Brand;
use VS\Next\Checkout\Domain\Cart\CartLine;
use Doctrine\Common\Collections\Collection;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Catalog\Domain\Category\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Promotions\Domain\Judgment\JudgmentId;
use VS\Next\Promotions\Domain\Promotion\Promotion;
use VS\Next\Promotions\Domain\Judgment\JudgmentName;
use VS\Next\Promotions\Domain\Profit\CartProfitInterface;
use VS\Next\Promotions\Domain\Profit\LineProfitInterface;
use VS\Next\Promotions\Domain\Shared\CalculatedCartDiscount;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;
use VS\Next\Promotions\Domain\Judgment\JudgmentProductIncluded;

class Judgment
{
    private Promotion $promotion;
    /** @var Collection<int, Category> */
    private Collection $categories;
    /** @var Collection<int, Brand> */
    private Collection $brands;
    private ?Profit $profit = null;
    /** @var Collection<int, JudgmentProductIncluded> */
    private Collection $productsIncluded;

    public function __construct(
        private JudgmentId $id,
        private JudgmentName $name,
    ) {
        $this->categories = new ArrayCollection();
        $this->brands = new ArrayCollection();
        $this->productsIncluded = new ArrayCollection();
    }

    public function setPromotion(Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getPromotion(): Promotion
    {
        return $this->promotion;
    }

    public function getId(): JudgmentId
    {
        return $this->id;
    }

    public function getName(): JudgmentName
    {
        return $this->name;
    }

    public function addCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            return $this;
        }

        $this->categories->add($category);

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            return $this;
        }
        $this->categories->removeElement($category);

        return $this;
    }

    /** @return Collection<int, Category> */
    public function getCategories(): Collection
    {
        return $this->categories;
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
        if (!$this->brands->contains($brand)) {
            return $this;
        }
        $this->brands->removeElement($brand);

        return $this;
    }

    /** @return Collection<int, Brand> */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function getProfit(): ?Profit
    {
        return $this->profit;
    }

    public function setProfit(?Profit $profit): self
    {
        if ($profit) {
            $profit->setJudgment($this);
        }

        $this->profit = $profit;

        return $this;
    }

    public function addProductIncluded(Product $product, int $group): self
    {
        $productIncluded = new JudgmentProductIncluded(Uuid::uuid4(), $this,  $product, $group);

        $this->productsIncluded->add($productIncluded);

        return $this;
    }

    public function removeProductIncluded(JudgmentProductIncluded $productIncluded): self
    {
        $this->productsIncluded->removeElement($productIncluded);

        return $this;
    }

    /** @return Collection<int, JudgmentProductIncluded> */
    public function getProductsIncluded(): Collection
    {
        return $this->productsIncluded;
    }

    public function isApplicableToCart(Cart $cart): bool
    {
        return (new JudgmentToCartChecker($this, $cart))();
    }

    public function applyToCart(Cart $cart): ?CalculatedCartDiscount
    {
        if ($this->getProfit() === null) {
            throw new InvalidArgumentException('The criteria does not include a benefit');
        }

        /** @var Profit&CartProfitInterface */
        $profit = $this->getProfit();

        return $profit->calculateProfitToCart($cart);
    }

    public function isApplicableToCartLine(CartLine $cartLine): bool
    {
        return (new JudgmentToCartLineChecker($this, $cartLine))();
    }

    public function applyToCartLine(CartLine $cartLine): ?CalculatedLineDiscount
    {
        if ($this->getProfit() === null) {
            throw new InvalidArgumentException('The criteria does not include a benefit');
        }

        /** @var Profit&LineProfitInterface */
        $profit = $this->getProfit();

        return $profit->calculateProfitToCartLine($cartLine);
    }
}
