<?php

declare(strict_types=1);

namespace App\Service;

interface ApiServiceInterface
{
    public function getContent(): ?array;
}