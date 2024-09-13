<?php

declare(strict_types=1);

namespace App\Model;

use App\Enums\MethodEnum;

class MethodDto
{
    public function __construct(
        public MethodEnum $method = MethodEnum::Fib
    ) {}
}
