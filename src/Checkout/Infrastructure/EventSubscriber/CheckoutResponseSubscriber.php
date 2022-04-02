<?php

namespace VS\Next\Checkout\Infrastructure\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use VS\Next\Checkout\Infrastructure\Service\CheckoutNormalize;

class CheckoutResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(private CheckoutNormalize $createCheckoutResponse)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => 'onView',
        ];
    }
    public function onView(ViewEvent $event): void
    {
        if (!$this->isCheckoutController($event)) {
            return;
        }

        $this->overwriteResponseWithCartData($event);
    }

    private function overwriteResponseWithCartData(ViewEvent   $event): void
    {
        $checkoutData = ($this->createCheckoutResponse)();

        $response = new JsonResponse($checkoutData);

        $event->setResponse($response);
    }


    private function isCheckoutController(ViewEvent $event): bool
    {
        $request = $event->getRequest();
        $controllerName = $request->attributes->get('_controller');

        if (!is_string($controllerName)) {
            return false;
        }

        return strpos($controllerName, 'VS\Next\Checkout\Infrastructure\Controller') === 0;
    }
}
