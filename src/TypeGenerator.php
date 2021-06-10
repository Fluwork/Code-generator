<?php

namespace Fluwork\CodeGenerator;

class TypeGenerator implements GeneratorInterface
{
    public function __construct(private string $type)
    {
    }

    public function generate(): string
    {
        if (in_array(
            $this->type,
            ['bool', 'int', 'float', 'string', 'array', 'iterable', 'void', 'null', 'object', 'callable']
        )) {
            return $this->type;
        }

        return sprintf('\%s', $this->type);
    }
}
