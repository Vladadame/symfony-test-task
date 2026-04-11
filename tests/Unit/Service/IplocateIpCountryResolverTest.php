<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\IplocateIpCountryResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class IplocateIpCountryResolverTest extends TestCase
{
    public function testResolveReturnsCountryFromApiResponse(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->with(false)->willReturn([
            'country' => 'United States',
        ]);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')->willReturn($response);

        $resolver = new IplocateIpCountryResolver($client);

        self::assertSame('United States', $resolver->resolve('8.8.8.8'));
    }

    public function testResolveReturnsNullWhenCountryIsMissing(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->with(false)->willReturn([]);

        $client = $this->createMock(HttpClientInterface::class);
        $client->method('request')->willReturn($response);

        $resolver = new IplocateIpCountryResolver($client);

        self::assertNull($resolver->resolve('8.8.8.8'));
    }
}