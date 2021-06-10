<?php

namespace Fluwork\CodeGenerator;

class TypeGenerator implements GeneratorInterface
{
    public function __construct(private string $type)
    {
    }

    public function generate(): string
    {
        return $this->type;
    }
}
