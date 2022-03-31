<?php

namespace VS\Next\Checkout\Infrastructure\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\ControllerDoesNotReturnResponseException;
use VS\Next\Checkout\Infrastructure\Service\CheckoutResponseCreator;

class CheckoutResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(private CheckoutResponseCreator $createCheckoutResponse)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onResponse',
            KernelEvents::EXCEPTION => 'onException'
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof ControllerDoesNotReturnResponseException) {
            return;
        }

        if (!$this->isCheckoutController($event)) {
            return;
        }

        $this->overwriteResponseWithCartData($event);
    }

    public function onResponse(ResponseEvent $event): void
    {
        if ($event->getResponse()->isServerError()) {
            return;
        }

        if ($event->getResponse()->isClientError()) {
            return;
        }

        if (!$this->isCheckoutController($event)) {
            return;
        }

        $this->overwriteResponseWithCartData($event);
    }

    private function overwriteResponseWithCartData(ResponseEvent | ExceptionEvent  $event): void
    {
        $checkoutData = ($this->createCheckoutResponse)();

        $response = new JsonResponse($checkoutData);

        $event->setResponse($response);
    }


    private function isCheckoutController(ResponseEvent | ExceptionEvent $event): bool
    {
        $request = $event->getRequest();
        $controllerName = $request->attributes->get('_controller');

        if (!is_string($controllerName)) {
            return false;
        }

        return strpos($controllerName, 'VS\Next\Checkout\Infrastructure\Controller') === 0;
    }
}
