<?php

namespace VS\Next\Checkout\Application\Content\SetProduct;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use VS\Next\Checkout\Application\Content\SetProduct\SetProductRequest;
use VS\Next\Checkout\Application\Content\Shared\ObtainCartLineFromRequestService;

class SetProductHandler implements MessageHandlerInterface
{
    public function __construct(
        private ObtainCartLineFromRequestService $obtainCartLineFromRequestService
    ) {
    }

    public function __invoke(SetProductRequest $request): void
    {
        $line = $this->obtainCartLineFromRequestService->findOrCreate($request);
        $line->ensureHasEnoughtStock($request->units);
        $line->setUnits($request->units);
    }
}
