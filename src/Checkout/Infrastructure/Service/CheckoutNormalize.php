<?php

namespace VS\Next\Checkout\Infrastructure\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use VS\Next\Checkout\Infrastructure\Service\CheckoutNormalizer\ContentNormalizer;
use VS\Next\Checkout\Infrastructure\Service\CheckoutNormalizer\ResumeNormalizer;

class CheckoutNormalize
{
    public function __construct(
        private ContentNormalizer $contentNormalizer,
        private ResumeNormalizer $resumeNormalizer
    ) {
    }

    /** @return array<string, mixed> */
    public function __invoke(): array
    {
        $resume = ($this->resumeNormalizer)();

        return [
            'content' => ($this->contentNormalizer)(),
            ...$resume
        ];
    }
}
