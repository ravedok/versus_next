<?php

namespace VS\Next\Shared\Infrastructure\EventSubscriber;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;

class ExceptionSubscriber implements EventSubscriberInterface
{
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

        $response = $this->createJsonReponse($exception);


        $event->setResponse($response);
    }

    private function isValidationException(ExceptionEvent $event): bool
    {
        return $event->getThrowable() instanceof ValidationFailedException;
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

    private function createJsonReponse(ValidationFailedException $exception): Response
    {
        $response = new JsonResponse($this->exceptionToArray($exception), Response::HTTP_BAD_REQUEST);

        return $response;
    }

    /** @return array<string, string> */
    private function exceptionToArray(ValidationFailedException $exception): array
    {
        $errors = [];

        /** @var ConstraintViolation $violation */
        foreach ($exception->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
