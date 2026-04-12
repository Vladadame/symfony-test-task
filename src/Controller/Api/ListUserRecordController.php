<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\Input\Api\ListUserRecordRequest;
use App\Repository\UserRecordRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
final class ListUserRecordController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    #[OA\Get(
        path: '/api/users',
        summary: 'Get stored user records',
        tags: ['Users']
    )]
    #[OA\Parameter(
        name: 'sort',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string', enum: ['firstName', 'lastName', 'country', 'createdAt'])
    )]
    #[OA\Parameter(
        name: 'order',
        in: 'query',
        required: false,
        schema: new OA\Schema(type: 'string', enum: ['asc', 'desc'])
    )]
    #[OA\Response(response: 200, description: 'List of stored user records')]
    public function __invoke(
        #[MapQueryString] ListUserRecordRequest $request,
        UserRecordRepository $repository,
    ): JsonResponse {
        
        return $this->json(
            $repository->findSorted($request),
            200,
            [],
            ['datetime_format' => DATE_ATOM],
        );
    }
}