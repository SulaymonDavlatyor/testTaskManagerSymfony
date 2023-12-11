<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'Error occured: %s',
            $exception->getMessage()
        );

        $response = new JsonResponse(['error' => $message], Response::HTTP_INTERNAL_SERVER_ERROR);

        $event->setResponse($response);
    }
}