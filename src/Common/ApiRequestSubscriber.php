<?php

namespace App\Common;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiRequestSubscriber implements EventSubscriberInterface
{
    const DEFAULT_JSON_DEPTH = 512;

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => "onRequest"];
    }

    public static function onRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (\is_resource($request->getContent())
            || $request->getContent() === ''
            || str_starts_with($request->getPathInfo(), '/api/doc')
            || !str_starts_with($request->getPathInfo(), '/api/')) {
            return;
        }

        if ($request->getContentType() !== 'json') {
            $event->setResponse(new JsonResponse('Invalid content type', Response::HTTP_BAD_REQUEST));

            return;
        }

        try {
            $requestContent = json_decode($request->getContent(), true, self::DEFAULT_JSON_DEPTH, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $event->setResponse(new JsonResponse('Invalid json string', Response::HTTP_BAD_REQUEST));

            return;
        }

        if (\is_array($requestContent)) {
            $request->request->replace($requestContent);
        }
    }

}