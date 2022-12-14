<?php

namespace VS\Next\Checkout\Application\Content\ReduceProduct;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use VS\Next\Checkout\Application\Content\ReduceProduct\ReduceProductRequest;
use VS\Next\Checkout\Application\Content\Shared\ObtainCartLineFromRequestService;

class ReduceProductHandler implements MessageHandlerInterface
{
    public function __construct(
        private ObtainCartLineFromRequestService $obtainCartLineFromRequestService
    ) {
    }

    public function __invoke(ReduceProductRequest $request): void
    {
        $line = $this->obtainCartLineFromRequestService->find($request);

        if (!$line) {
            return;
        }

        $line->reduceUnits($request->units);
    }
}
