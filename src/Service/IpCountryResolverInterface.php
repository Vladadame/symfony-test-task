<?php

namespace App\Service;

interface IpCountryResolverInterface
{
    public function resolve(string $ip): ?string;
}