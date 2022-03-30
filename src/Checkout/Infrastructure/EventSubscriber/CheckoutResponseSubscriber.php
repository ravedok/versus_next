<?php

namespace VS\Next\Checkout\Infrastructure\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use VS\Next\Checkout\Infrastructure\Service\CheckoutResponseCreator;

class CheckoutResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(private CheckoutResponseCreator $createCheckoutResponse)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onResponse'
        ];
    }

    public function onResponse(ResponseEvent $event): void
    {
        if (!$this->isCheckoutController($event)) {
            return;
        }

        $checkoutData = ($this->createCheckoutResponse)();

        $response = new JsonResponse($checkoutData);

        $event->setResponse($response);
    }


    private function isCheckoutController(ResponseEvent $event): bool
    {
        $request = $event->getRequest();
        $controllerName = $request->attributes->get('_controller');

        if (!is_string($controllerName)) {
            return false;
        }

        return strpos($controllerName, 'VS\Next\Checkout\Infrastructure\Controller') === 0;
    }
}
