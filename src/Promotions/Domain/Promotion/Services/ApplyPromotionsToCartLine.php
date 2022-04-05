<?php

namespace VS\Next\Promotions\Domain\Promotion\Services;

use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Promotions\Domain\Shared\DiscountHelper;
use VS\Next\Promotions\Domain\Shared\CalculatedLineDiscount;
use VS\Next\Catalog\Domain\Product\Entity\ProductOfferableInterface;

class ApplyPromotionsToCartLine
{
    /** @param Judgment[] $judgments  */
    public  function __invoke(array $judgments, CartLine $cartLine): void
    {
        $candidates = [];

        $this->recoveryDiscountFromProductOffer($candidates, $cartLine);
        $this->recoveryDiscountsFromJudgments($candidates, $cartLine, $judgments);
        $discount = $this->reduceCandidates($candidates);

        $cartLine->setAppliedDiscount($discount);
    }

    /** @param CalculatedLineDiscount[] $candidates */
    private function reduceCandidates(array $candidates): ?CalculatedLineDiscount
    {
        return array_reduce($candidates, function (?CalculatedLineDiscount $carry, CalculatedLineDiscount $current) {
            if ($carry === null) {
                return $current;
            }

            if ($current->getDiscountedAmount() > $carry->getDiscountedAmount()) {
                return $current;
            }

            return $carry;
        }, null);
    }

    /**
     * @param CalculatedLineDiscount[] $candidates
     * @param Judgment[] $judgments 
     * */
    private function recoveryDiscountsFromJudgments(array &$candidates, CartLine $cartLine, array $judgments): void
    {
        foreach ($judgments as $judgment) {
            if ($judgment->isApplicableToCartLine($cartLine)) {
                $candidates[] = $judgment->applyToCartLine($cartLine);
            }
        }
    }

    /**
     * @param CalculatedLineDiscount[] $candidates
     */
    private function recoveryDiscountFromProductOffer(array &$candidates, CartLine $cartLine): void
    {
        $product = $cartLine->getProduct();

        if ($product->isOfferable() === false) {
            return;
        }

        /** @var Product&ProductOfferableInterface $product */
        $offer = $product->getOffer();

        if (false === $offer->isApplicable()) {
            return;
        }

        $discount = new CalculatedLineDiscount(
            $product,
            $offer->getType(),
            DiscountHelper::calculateDiscountPercent($product->getPrice(), $offer->getPrice())
        );

        $candidates[] = $discount;
    }
}
