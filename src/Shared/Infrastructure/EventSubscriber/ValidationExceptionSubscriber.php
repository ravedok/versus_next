<?php

namespace VS\Next\Shared\Infrastructure\EventSubscriber;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Messenger\Exception\ValidationFailedException as ValidationMessengerFailedException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onException'
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        if (!$this->isValidationException($event)) {
            return;
        }

        if (!$this->isNextController($event)) {
            return;
        }

        /** @var ValidationFailedException */
        $exception = $event->getThrowable();

        $response = $this->createJsonReponse($exception->getViolations());


        $event->setResponse($response);
    }

    private function isValidationException(ExceptionEvent $event): bool
    {
        return $event->getThrowable() instanceof ValidationMessengerFailedException
            || $event->getThrowable() instanceof ValidationFailedException;
    }

    private function isNextController(ExceptionEvent $event): bool
    {
        $request = $event->getRequest();

        if (!$request->attributes->has('_controller')) {
            return false;
        }

        $controllerName = $request->attributes->get('_controller');

        if (!is_string($controllerName)) {
            return false;
        }

        return strpos($controllerName, 'VS\Next') === 0;
    }

    private function createJsonReponse(ConstraintViolationListInterface $violations): Response
    {
        $data = $this->serializer->serialize($violations, 'json', array_merge([
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ]));

        return new JsonResponse($data, Response::HTTP_BAD_REQUEST, [], true);
    }
}
