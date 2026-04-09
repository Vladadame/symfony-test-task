<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class IplocateIpCountryResolver implements IpCountryResolverInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    public function resolve(string $ip): ?string
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('https://www.iplocate.io/api/lookup/%s', $ip)
            );

            $data = $response->toArray(false);

            return $data['country'] ?? null;
        } catch (ExceptionInterface) {
            return null;
        }
    }
}