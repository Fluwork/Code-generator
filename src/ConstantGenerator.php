<?php

namespace Fluwork\CodeGenerator;

class ConstantGenerator implements GeneratorInterface
{
    public function __construct(private string $name, private mixed $value, private ?string $visibility = null)
    {
    }

    public function generate(): string
    {
        return sprintf(
            '%sconst %s = %s;',
            null !== $this->visibility ? sprintf('%s ', $this->visibility) : '',
            $this->name,
            (new ValueGenerator($this->value))->generate()
        );
    }
}
