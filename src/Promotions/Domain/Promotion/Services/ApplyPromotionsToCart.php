<?php

namespace VS\Next\Promotions\Domain\Promotion\Services;

use VS\Next\Checkout\Domain\Cart\Cart;
use VS\Next\Checkout\Domain\Cart\CartLine;
use VS\Next\Promotions\Domain\Judgment\Judgment;
use VS\Next\Catalog\Domain\Product\Entity\Product;
use VS\Next\Promotions\Domain\Shared\CalculatedDiscount;
use VS\Next\Promotions\Domain\Judgment\JudgmentRepository;
use VS\Next\Catalog\Domain\Product\Entity\ProductOfferableInterface;
use VS\Next\Promotions\Domain\Shared\DiscountHelper;

class ApplyPromotionsToCart
{
    public function __construct(private JudgmentRepository $judgmentRepository)
    {
    }
    public function __invoke(Cart $cart): void
    {
        $judgments = $this->judgmentRepository->findActives();

        $this->applyToLines($judgments, $cart->getLines()->toArray());
    }

    /** 
     * @param Judgment[] $judgments 
     * @param CartLine[] $lines
     * */
    private function applyToLines(array $judgments, array $lines): void
    {
        foreach ($lines as $line) {
            if (!$line->getProduct()->isAllowPromotions()) {
                continue;
            }

            $this->applyToLine($judgments, $line);
        }
    }

    /** @param Judgment[] $judgments  */
    private function applyToLine(array $judgments, CartLine $cartLine): void
    {
        $candidates = [];

        $this->recoveryDiscountFromProductOffer($candidates, $cartLine);
        $this->recoveryDiscountsFromJudgments($candidates, $cartLine, $judgments);
        $discount = $this->reduceCandidates($candidates);

        $cartLine->setAppliedDiscount($discount);
    }

    /** @param CalculatedDiscount[] $candidates */
    private function reduceCandidates(array $candidates): ?CalculatedDiscount
    {
        return array_reduce($candidates, function (?CalculatedDiscount $carry, CalculatedDiscount $current) {
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
     * @param CalculatedDiscount[] $candidates
     * @param Judgment[] $judgments 
     * */
    private function recoveryDiscountsFromJudgments(array &$candidates, CartLine $cartLine, array $judgments): void
    {
        foreach ($judgments as $judgment) {
            if ($judgment->applicableToCartLine($cartLine)) {
                $candidates[] = $judgment->applyToCartLine($cartLine);
            }
        }
    }

    /**
     * @param CalculatedDiscount[] $candidates
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

        $discount = new CalculatedDiscount(
            $product,
            $offer->getType(),
            DiscountHelper::calculateDiscountPercent($product->getPrice(), $offer->getPrice())
        );

        $candidates[] = $discount;
    }
}
