<?php

namespace VS\Next\Checkout\Infrastructure\Controller\Shared;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractHandlerController extends AbstractController
{
    use HandleTrait {
        handle as private handleMessage;
    }

    private DenormalizerInterface $denormalizer;
    private RequestStack $requestStack;

    protected function handle(object $message): mixed
    {
        return $this->handleMessage($message);
    }

    protected function handleFromRequest(string $requestNameClass): mixed
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            throw new \Exception("There is no request to manage", 1);
        }

        $data = $request->toArray();

        $message = $this->denormalizer->denormalize($data, $requestNameClass, null, [
            DenormalizerInterface::COLLECT_DENORMALIZATION_ERRORS => true
        ]);

        return $this->handle($message);
    }

    /**
     * @required
     */
    public function setMessageBus(MessageBusInterface $messageBus): void
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @required
     */
    public function setDenormalizer(DenormalizerInterface $denormalizer): void
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * @required
     */
    public function setRequestStack(RequestStack $requestStack): void
    {
        $this->requestStack = $requestStack;
    }
}
