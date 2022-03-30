<?php

namespace VS\Next\Checkout\Domain\Cart;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Checkout\Domain\Cart\CartLineOption;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Catalog\Domain\Product\Entity\ProductCustomizableStockInterface;
use VS\Next\Catalog\Domain\Product\Exception\ProductIsNotCustomizableException;

class CustomizedCartLine extends CartLine
{
    /** @var ArrayCollection<int, CartLineOption> */
    private Collection $options;

    public function __construct(Product $product, int $units = 0)
    {
        $this->ensureCustomizableAllowed($product);
        $this->type = CartLineType::createCustomized();
        $this->options = new ArrayCollection();
        parent::__construct($product, $units);
    }

    protected function maxUnits(): ?int
    {
        $maxUnitsFromProduct = $this->maxUnitsFromProduct($this->getProduct());

        if (!$maxUnitsFromProduct) {
            return 0;
        }

        foreach ($this->getOptions() as $option) {

            $maxUnitsFromOption = $this->maxUnitsFromProduct($option->getProduct());

            if ($maxUnitsFromOption < $maxUnitsFromProduct) {
                $maxUnitsFromProduct = $maxUnitsFromOption;
            }

            if ($maxUnitsFromOption <= 0) {
                return 0;
            }
        }

        return $maxUnitsFromProduct;
    }

    private function maxUnitsFromProduct(Product $product): int
    {
        $availableStock = $product->getAvailableStock();

        foreach ($this->getCart()->getLines() as $cartLine) {
            $this->reduceAvailableStockFormCartLine($product, $cartLine, $availableStock);
        }

        return $availableStock;
    }

    private function reduceAvailableStockFormCartLine(Product $product, CartLine $cartLine, int &$availableStock): void
    {
        if (!$cartLine instanceof NormalCartLine && !$cartLine instanceof CustomizedCartLine) {
            return;
        }

        if ($product === $cartLine->getProduct()) {
            $availableStock -= $cartLine->getUnits();
        }

        if (!$cartLine instanceof CustomizedCartLine) {
            return;
        }

        foreach ($cartLine->getOptions() as $option) {
            if ($product === $option->getProduct()) {
                $availableStock -= $cartLine->getUnits() * $option->getUnits();
            }
        }
    }

    /** @return ArrayCollection<int, CartLineOption> */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(CartLineOption $option): self
    {
        if ($this->options->contains($option)) {
            return $this;
        }

        $option->setCartLine($this);

        $this->options->add($option);

        return $this;
    }

    public function similar(CartLine $otherLine): bool
    {
        if (!$otherLine instanceof CustomizedCartLine) {
            return false;
        }

        if ($this->getProduct() !== $otherLine->getProduct()) {
            return false;
        }

        return $this->similarOptions($otherLine);
    }

    private function similarOptions(CustomizedCartLine $otherLine): bool
    {
        if ($this->getOptions()->count() !== $otherLine->getOptions()->count()) {
            return false;
        }

        $options = clone $this->getOptions();

        foreach ($otherLine->getOptions() as $otherOption) {
            /** @var CartLineOption $option */
            foreach ($options as $option) {
                if ($option->similar($otherOption)) {
                    $options->removeElement($option);
                    break;
                }
            }
        }

        return $options->count() === 0;
    }

    private function ensureCustomizableAllowed(Product $product): void
    {
        if (!$product instanceof ProductCustomizableStockInterface) {
            throw new ProductIsNotCustomizableException;
        }

        if (!$product->isCustomizable()) {
            throw new ProductIsNotCustomizableException;
        }
    }
}
