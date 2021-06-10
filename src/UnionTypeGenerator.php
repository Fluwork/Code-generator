<?php

namespace Fluwork\CodeGenerator;

class UnionTypeGenerator implements GeneratorInterface
{
    private array $types;

    public function __construct(TypeGenerator ...$types)
    {
        $this->types = $types;
    }

    public function generate(): string
    {
        $types = array_map(fn(TypeGenerator $generator) => $generator->generate(), $this->types);

        return join('|', $types);
    }
}
