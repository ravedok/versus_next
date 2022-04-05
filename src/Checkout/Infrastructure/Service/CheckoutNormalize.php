<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use VS\Next\Checkout\Domain\Cart\CartRepository;
use VS\Next\Promotions\Domain\Promotion\Services\ApplyPromotionsToCart;
use VS\Next\Checkout\Infrastructure\Service\CheckoutNormalizer\ResumeNormalizer;
use VS\Next\Checkout\Infrastructure\Service\CheckoutNormalizer\ContentNormalizer;

class CheckoutNormalize
{
    public function __construct(
        private ContentNormalizer $contentNormalizer,
        private ResumeNormalizer $resumeNormalizer,
        private CartRepository $cartRepository,
        private ApplyPromotionsToCart $applyPromotionsToCart
    ) {
    }

    /** @return array<string, mixed> */
    public function __invoke(): array
    {
        $cart = $this->cartRepository->current();

        ($this->applyPromotionsToCart)($cart);

        $resume = ($this->resumeNormalizer)();

        return [
            'content' => ($this->contentNormalizer)(),
            ...$resume
        ];
    }
}
