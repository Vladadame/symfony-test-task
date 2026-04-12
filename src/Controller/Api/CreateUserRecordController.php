<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Message\CreateUserRecordMessage;
use App\Request\CreateUserRecordRequest;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/users')]
final class CreateUserRecordController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    #[OA\Post(
        path: '/api/users',
        summary: 'Accept user record for asynchronous processing',
        tags: ['Users'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['firstName', 'lastName', 'phoneNumbers'],
                properties: [
                    new OA\Property(property: 'firstName', type: 'string', example: 'Yura'),
                    new OA\Property(property: 'lastName', type: 'string', example: 'Test'),
                    new OA\Property(
                        property: 'phoneNumbers',
                        type: 'array',
                        items: new OA\Items(type: 'string'),
                        example: ['+380971234567', '+380631234567']
                    ),
                ]
            )
        )
    )]
    #[OA\Response(response: 202, description: 'Accepted for processing')]
    #[OA\Response(response: 400, description: 'Invalid JSON payload')]
    #[OA\Response(response: 422, description: 'Validation failed')]
    public function __invoke(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        MessageBusInterface $bus,
    ): JsonResponse {
        try {
            /** @var CreateUserRecordRequest $dto */
            $dto = $serializer->deserialize(
                $request->getContent(),
                CreateUserRecordRequest::class,
                'json'
            );
        } catch (ExceptionInterface) {
            return $this->json(
                ['message' => 'Invalid JSON payload'],
                Response::HTTP_BAD_REQUEST
            );
        }

        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            $formattedErrors = [];

            foreach ($errors as $error) {
                $formattedErrors[] = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                ];
            }

            return $this->json(
                [
                    'message' => 'Validation failed',
                    'errors' => $formattedErrors,
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $ip = $request->getClientIp() ?? '8.8.8.8';

        $bus->dispatch(new CreateUserRecordMessage(
            $dto->firstName,
            $dto->lastName,
            $dto->phoneNumbers,
            $ip,
        ));

        return $this->json(
            ['message' => 'Accepted for processing'],
            Response::HTTP_ACCEPTED
        );
    }
}