<?php

namespace VS\Next\Promotions\Domain\Judgment;

use InvalidArgumentException;
use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\CartLine;
use Doctrine\Common\Collections\Collection;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Catalog\Domain\Category\Category;
use Doctrine\Common\Collections\ArrayCollection;
use VS\Next\Promotions\Domain\Judgment\JudgmentId;
use VS\Next\Promotions\Domain\Promotion\Promotion;
use VS\Next\Promotions\Domain\Judgment\JudgmentName;
use VS\Next\Promotions\Domain\Profit\CartProfitInterface;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;
use VS\Next\Promotions\Domain\Profit\LineProfitInterface;
use VS\Next\Promotions\Domain\Shared\CalculatedCartDiscount;

class Judgment
{
    private Promotion $promotion;
    /** @var Collection<int, Category> */
    private Collection $categories;
    private ?Profit $profit = null;

    public function __construct(
        private JudgmentId $id,
        private JudgmentName $name,
    ) {
        $this->categories = new ArrayCollection();
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

    public function isApplicableToCart(Cart $cart): bool
    {
        return (new JudgmentToCartChecker($this, $cart))();
    }

    public function applyToCart(Cart $cart): CalculatedCartDiscount
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

    public function applyToCartLine(CartLine $cartLine): CalculatedLineDiscount
    {
        if ($this->getProfit() === null) {
            throw new InvalidArgumentException('The criteria does not include a benefit');
        }

        /** @var Profit&LineProfitInterface */
        $profit = $this->getProfit();

        return $profit->calculateProfitToCartLine($cartLine);
    }
}
