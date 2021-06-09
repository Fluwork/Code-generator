<?php

namespace Fluwork\CodeGenerator;

class FileGenerator implements GeneratorInterface
{
    private array $generators;

    public function __construct(GeneratorInterface ...$generators)
    {
        $this->generators = $generators;
    }

    public function addGenerators(GeneratorInterface ...$generators): self
    {
        $this->generators = array_merge($this->generators, $generators);

        return $this;
    }

    public function generate(): string
    {
        if (!$this->generators) {
            return "<?php\n";
        }

        $generatorsCode = array_map(fn(GeneratorInterface $generator) => $generator->generate(), $this->generators);
        $code = join("\n\n", $generatorsCode);

        return "<?php\n\n$code\n";
    }
}
