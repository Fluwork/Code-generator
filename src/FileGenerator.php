<?php

namespace Fluwork\CodeGenerator;

class FileGenerator implements GeneratorInterface
{
    private array $generators;

    public function __construct(GeneratorInterface ...$generators)
    {
        $this->generators = $generators;
    }

    public function addGenerators(GeneratorInterface ...$generators): static
    {
        $this->generators = array_merge($this->generators, $generators);

        return $this;
    }

    public function addBlock(): BlockGenerator
    {
        $this->addGenerators($generator = new BlockGenerator());

        return $generator;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        if (!$this->generators) {
            return "<?php\n";
        }

        $generatorsCode = array_map(fn(GeneratorInterface $generator) => $generator->generate(), $this->generators);
        $code = join("\n\n", $generatorsCode);

        return "<?php\n\n$code\n";
    }

    public function addFunction(string $name): FunctionGenerator
    {
        $this->addGenerators($generator = new FunctionGenerator($name));

        return $generator;
    }

    public function addNamespace(string $namespace): static
    {
        return $this->addGenerators(new NamespaceGenerator($namespace));
    }

    public function addClass(string $name): ClassGenerator
    {
        $this->addGenerators($generator = new ClassGenerator($name));

        return $generator;
    }
}
