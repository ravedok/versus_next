<?php

namespace VS\Next\Checkout\Application\Content\AddProduct;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use VS\Next\Checkout\Application\Content\AddProduct\AddProductRequest;
use VS\Next\Checkout\Application\Content\Shared\ObtainCartLineFromRequestService;

class AddProductHandler implements MessageHandlerInterface
{
    public function __construct(
        private ObtainCartLineFromRequestService $obtainCartLineFromRequestService
    ) {
    }

    public function __invoke(AddProductRequest $request): void
    {
        $line = $this->obtainCartLineFromRequestService->findOrCreate($request);

        $finalUnits = $line->getUnits() + $request->units;

        $line->ensureHasEnoughtStock($finalUnits);

        $line->addUnits($request->units);
    }
}
