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
    public function __invoke(array $judgments, CartLine $cartLine): void
    {
        $candidates = [];

        $this->recoveryDiscountFromProductOffer($candidates, $cartLine);
        $this->recoveryDiscountsFromJudgments($candidates, $cartLine, $judgments);

        $this->applyBestDiscountToLine($cartLine, $candidates);
    }

    /** @param CalculatedLineDiscount[] $candidates */
    private function applyBestDiscountToLine(CartLine $cartLine, array $candidates): void
    {
        $discount = $this->reduceCandidates($candidates);

        $this->applyPartialDiscount($cartLine, $discount, $candidates);

        $cartLine->setAppliedDiscount($discount);
    }

    private function applyPartialDiscount(CartLine $cartLine, ?CalculatedLineDiscount $discount, array $candidates): void
    {
        if ($discount === null) {
            return;
        }

        $remainingUnits = $cartLine->getUnits() - $discount->getUnits();

        if ($remainingUnits <= 0) {
            return;
        }

        $partialLine = (clone $cartLine)->setUnits($remainingUnits);

        $cartLine->getCart()->addLine($partialLine);

        $cartLine->setUnits($discount->getUnits());

        unset($candidates[array_search($discount, $candidates, true)]);

        $this->applyBestDiscountToLine($partialLine, $candidates);
    }

    /** @param CalculatedLineDiscount[] $candidates */
    private function reduceCandidates(array $candidates): ?CalculatedLineDiscount
    {
        $candidates = array_filter($candidates);

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
        $applicableJudgments = array_filter($judgments, fn (Judgment $judgment) => $judgment->isApplicableToCartLine($cartLine));

        foreach ($applicableJudgments as $judgment) {
            if ($discount = $judgment->applyToCartLine($cartLine)) {
                $candidates[] = $discount;
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
            $cartLine,
            $offer->getType(),
            DiscountHelper::calculateDiscountPercent($product->getPrice(), $offer->getPrice()),
            $cartLine->getUnits()
        );

        $candidates[] = $discount;
    }
}
