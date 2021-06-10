<?php

namespace Fluwork\CodeGenerator;

class InterfaceMethodGenerator implements GeneratorInterface
{
    protected RootTypeGenerator|UnionTypeGenerator|null $returnType = null;
    protected ?ParametersGenerator $parameters = null;

    public function __construct(protected string $name, protected ?string $visibility = null)
    {
    }

    public function generate(): string
    {
        return sprintf(
            '    %sfunction %s(%s)%s;',
            null !== $this->visibility ? sprintf('%s ', $this->visibility) : '',
            $this->name,
            null !== $this->parameters ? $this->parameters->generate() : '',
            null !== $this->returnType ? sprintf(': %s', $this->returnType->generate()) : ''
        );
    }

    public function setReturnType(string $returnType): self
    {
        return $this->setReturnTypeGenerator(new RootTypeGenerator($returnType));
    }

    public function setReturnTypeGenerator(RootTypeGenerator|UnionTypeGenerator $returnTypeGenerator): static
    {
        $this->returnType = $returnTypeGenerator;

        return $this;
    }

    public function setReturnUnionType(string ...$types): self
    {
        $typeGenerators = array_map(fn(string $type) => new TypeGenerator($type), $types);

        return $this->setReturnTypeGenerator(new UnionTypeGenerator(...$typeGenerators));
    }

    public function setParameters(ParametersGenerator $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }
}
