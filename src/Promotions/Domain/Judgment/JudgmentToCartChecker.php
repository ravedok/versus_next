<?php

namespace VS\Next\Promotions\Domain\Judgment;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Promotions\Domain\Profit\CartProfitInterface;

class JudgmentToCartChecker
{
    public function __construct(private Judgment $judgment, private Cart $cart)
    {
    }

    public function __invoke(): bool
    {
        if (!$this->isValidProfit()) {
            return false;
        }

        if (!$this->isValidCategory()) {
            return false;
        }

        if (!$this->hasSomeIncludedProducts()) {
            return false;
        }

        return true;
    }

    private function isValidProfit(): bool
    {
        $profit = $this->judgment->getProfit();

        if ($profit === null) {
            return false;
        }

        if (!$profit instanceof CartProfitInterface) {
            return false;
        }

        return true;
    }

    private function isValidCategory(): bool
    {
        $categories = $this->judgment->getCategories()->toArray();

        if (empty($categories)) {
            return true;
        }

        foreach ($this->cart->getLines() as $line) {
            $productCategory = $line->getProduct()->getCategory();

            if (in_array($productCategory, $categories)) {
                return true;
            }
        }

        return false;
    }

    private function hasSomeIncludedProducts(): bool
    {
        $productsIncluded = $this->judgment
            ->getProductsIncluded()
            ->map(fn (JudgmentProductIncluded $productIncluded) => $productIncluded->getProduct())
            ->toArray();

        if (empty($productsIncluded)) {
            return true;
        }

        $productsInCart = $this->cart
            ->getLines()
            ->map(fn (CartLine $cartLine) => $cartLine->getProduct())
            ->toArray();

        foreach ($productsIncluded as $product) {
            if (in_array($product, $productsInCart)) {
                return true;
            }
        }

        return false;
    }
}
