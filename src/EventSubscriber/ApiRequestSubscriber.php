<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly string $apiKey,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $path = $request->getPathInfo();

        if (!in_array($path, ['/api/users'], true)) {
            return;
        }

        $providedApiKey = $request->headers->get('X-API-Key');

        if ($providedApiKey !== $this->apiKey) {
            $event->setResponse(new JsonResponse(
                ['message' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            ));
        }
    }
}