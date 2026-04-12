<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\Input\Api\ListUserRecordRequest;
use App\Repository\UserRecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users')]
final class ListUserRecordController extends AbstractController
{
    #[Route('', methods: ['GET'])]
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