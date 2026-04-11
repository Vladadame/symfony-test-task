<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\UserRecordRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        Request $request,
        UserRecordRepository $repository,
    ): JsonResponse {
        $allowedSortFields = ['firstName', 'lastName', 'country', 'createdAt'];
        $allowedOrders = ['asc', 'desc'];

        $sort = $request->query->getString('sort', 'createdAt');
        $order = strtolower($request->query->getString('order', 'desc'));

        if (!in_array($sort, $allowedSortFields, true)) {
            $sort = 'createdAt';
        }

        if (!in_array($order, $allowedOrders, true)) {
            $order = 'desc';
        }

        $users = $repository->findSorted($sort, $order);

        $data = [];

        foreach ($users as $user) {
            $phones = [];

            foreach ($user->getPhoneNumbers() as $phoneNumber) {
                $phones[] = $phoneNumber->getPhoneNumber();
            }

            $data[] = [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'ipAddress' => $user->getIpAddress(),
                'country' => $user->getCountry(),
                'phoneNumbers' => $phones,
                'createdAt' => $user->getCreatedAt()->format(DATE_ATOM),
            ];
        }

        return $this->json($data);
    }
}