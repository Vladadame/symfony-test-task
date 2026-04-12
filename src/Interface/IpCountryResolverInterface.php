<?php

namespace App\Interface;

interface IpCountryResolverInterface
{
    public function resolve(string $ip): ?string;
}