<?php

namespace Fluwork\CodeGenerator;

class ValueGenerator implements GeneratorInterface
{
    public function __construct(private mixed $value)
    {
    }

    public function generate(): string
    {
        return var_export($this->value, true);
    }
}
