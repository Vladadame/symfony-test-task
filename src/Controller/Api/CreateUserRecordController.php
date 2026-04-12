<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\Input\Api\CreateUserRecordRequest;
use App\Message\CreateUserRecordMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
final class CreateUserRecordController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] CreateUserRecordRequest $request,
        Request $httpRequest,
        MessageBusInterface $bus,
    ): JsonResponse {
        $ip = $httpRequest->getClientIp() ?? '8.8.8.8';

        $bus->dispatch(new CreateUserRecordMessage(
            $request->firstName,
            $request->lastName,
            $request->phoneNumbers,
            $ip,
        ));

        return $this->json(
            ['message' => 'Accepted for processing'],
            Response::HTTP_ACCEPTED
        );
    }
}