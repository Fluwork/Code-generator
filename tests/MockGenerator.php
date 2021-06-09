<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\GeneratorInterface;

class MockGenerator implements GeneratorInterface
{
    public function __construct(private string $code)
    {
    }

    public function generate(): string
    {
        return $this->code;
    }
}
