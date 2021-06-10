<?php

namespace Fluwork\CodeGenerator;

class RootTypeGenerator extends TypeGenerator
{
    public function __construct(string $name, private bool $nullable = false)
    {
        parent::__construct($name);
    }

    public function generate(): string
    {
        return sprintf('%s%s', $this->nullable ? '?' : '', parent::generate());
    }
}
