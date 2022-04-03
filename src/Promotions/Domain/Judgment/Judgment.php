<?php

namespace VS\Next\Promotions\Domain\Judgment;

use Doctrine\Common\Collections\Collection;
use VS\Next\Promotions\Domain\Profit\Profit;
use VS\Next\Catalog\Domain\Category\Category;
use Doctrine\Common\Collections\ArrayCollection;
use VS\Next\Promotions\Domain\Judgment\JudgmentId;
use VS\Next\Promotions\Domain\Promotion\Promotion;
use VS\Next\Promotions\Domain\Judgment\JudgmentName;

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
        $this->profit = $profit;

        return $this;
    }
}