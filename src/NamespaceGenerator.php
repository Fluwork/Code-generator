<?php

namespace Fluwork\CodeGenerator;

class NamespaceGenerator implements GeneratorInterface
{
    public function __construct(private string $namespace)
    {
    }

    public function generate(): string
    {
        return sprintf('namespace %s;', $this->namespace);
    }
}
