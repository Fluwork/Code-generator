<?php

namespace Fluwork\CodeGenerator;

class ParametersGenerator implements GeneratorInterface
{
    private array $parameters;

    public function __construct(ParameterGenerator ...$parameters)
    {
        $this->parameters = $parameters;
    }

    public function generate(): string
    {
        $parameters = array_map(fn(ParameterGenerator $generator) => $generator->generate(), $this->parameters);

        return join(', ', $parameters);
    }
}
