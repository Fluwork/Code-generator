<?php

namespace Fluwork\CodeGenerator;

use InvalidArgumentException;

class ParameterGenerator implements GeneratorInterface
{
    public function __construct(
        private string $name,
        private RootTypeGenerator|UnionTypeGenerator|null $type = null,
        private ?ValueGenerator $defaultValue = null,
        private ?string $propertyVisibility = null,
        private bool $variadic = false
    ) {
        if ($this->variadic && null !== $this->propertyVisibility) {
            throw new InvalidArgumentException('Cannot declare variadic promoted property');
        }
    }

    public function generate(): string
    {
        $code = '';

        if (null !== $this->propertyVisibility) {
            $code .= sprintf('%s ', $this->propertyVisibility);
        }

        if (null !== $this->type) {
            $code .= sprintf('%s ', $this->type->generate());
        }

        if ($this->variadic) {
            $code .= '...';
        }

        $code .= sprintf('$%s', $this->name);

        if (null !== $this->defaultValue) {
            $code .= sprintf(' = %s', $this->defaultValue->generate());
        }

        return $code;
    }
}
