<?php

namespace Fluwork\CodeGenerator;

class PropertyGenerator implements GeneratorInterface
{
    private RootTypeGenerator|UnionTypeGenerator|null $type = null;
    private ?ValueGenerator $default = null;

    public function __construct(private string $name, private string $visibility)
    {
    }

    public function generate(): string
    {
        return sprintf(
            '%s%s $%s%s;',
            $this->visibility,
            null !== $this->type ? sprintf(' %s', $this->type->generate()) : '',
            $this->name,
            null !== $this->default ? sprintf(' = %s', $this->default->generate()) : ''
        );
    }

    public function setType(string $type): static
    {
        return $this->setTypeGenerator(new RootTypeGenerator($type));
    }

    public function setTypeGenerator(RootTypeGenerator|UnionTypeGenerator $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function setUnionType(string ...$types): static
    {
        $typeGenerators = array_map(fn(string $type) => new TypeGenerator($type), $types);

        return $this->setTypeGenerator(new UnionTypeGenerator(...$typeGenerators));
    }

    public function setDefault(mixed $value): static
    {
        $this->default = new ValueGenerator($value);

        return $this;
    }
}
