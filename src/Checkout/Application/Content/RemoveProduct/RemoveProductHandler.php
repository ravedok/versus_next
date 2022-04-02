<?php

namespace VS\Next\Checkout\Application\Content\RemoveProduct;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use VS\Next\Checkout\Application\Content\RemoveProduct\RemoveProductRequest;
use VS\Next\Checkout\Application\Content\Shared\ObtainCartLineFromRequestService;

class RemoveProductHandler implements MessageHandlerInterface
{
    public function __construct(
        private ObtainCartLineFromRequestService $obtainCartLineFromRequestService
    ) {
    }

    public function __invoke(RemoveProductRequest $request): void
    {
        $line = $this->obtainCartLineFromRequestService->find($request);

        if ($line) {
            $line->getCart()->removeLine($line);
        }
    }
}
