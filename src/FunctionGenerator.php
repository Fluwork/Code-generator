<?php

namespace Fluwork\CodeGenerator;

class FunctionGenerator implements GeneratorInterface
{
    private ?BlockGenerator $content = null;
    private RootTypeGenerator|UnionTypeGenerator|null $returnType = null;
    private ?ParametersGenerator $parameters = null;

    public function __construct(private string $name)
    {
    }

    public function getContent(): BlockGenerator
    {
        if (null === $this->content) {
            $this->content = new BlockGenerator();
        }

        return $this->content;
    }

    public function generate(): string
    {
        $code = <<<PHP
function %s(%s)%s
{
%s}
PHP;

        return sprintf(
            $code,
            $this->name,
            null !== $this->parameters ? $this->parameters->generate() : '',
            null !== $this->returnType ? sprintf(': %s', $this->returnType->generate()) : '',
            null !== $this->content ? sprintf("%s\n", $this->content->setBaseIndentation(1)->generate()) : ''
        );
    }

    public function setContent(BlockGenerator $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function setReturnTypeGenerator(RootTypeGenerator|UnionTypeGenerator $returnTypeGenerator): static
    {
        $this->returnType = $returnTypeGenerator;

        return $this;
    }

    public function setReturnType(string $returnType): self
    {
        return $this->setReturnTypeGenerator(new RootTypeGenerator($returnType));
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
