<?php

namespace Fluwork\CodeGenerator;

use LogicException;

class ClassGenerator implements GeneratorInterface
{
    private ?TypeGenerator $parentClass = null;
    private ?array $interfaces = null;
    /** @var PropertyGenerator[] */
    private array $properties = [];
    /** @var ConstantGenerator[] */
    private array $constants = [];
    private bool $abstract = false;
    private bool $final = false;
    /** @var MethodGenerator[] */
    private array $methods = [];

    public function __construct(private string $name)
    {
    }

    public function setAbstract(): static
    {
        if ($this->final) {
            throw new LogicException('Cannot declare abstract and final class');
        }

        $this->abstract = true;

        return $this;
    }

    public function setFinal(): static
    {
        if ($this->abstract) {
            throw new LogicException('Cannot declare abstract and final class');
        }

        $this->final = true;

        return $this;
    }

    public function generate(): string
    {
        $code = <<<PHP
%sclass %s%s%s
{
%s}
PHP;

        return sprintf(
            $code,
            $this->abstract ? 'abstract ' : ($this->final ? 'final ' : ''),
            $this->name,
            null !== $this->parentClass ? sprintf(' extends %s', $this->parentClass->generate()) : '',
            $this->generateInterfaces(),
            $this->generateContent()
        );
    }

    private function generateInterfaces(): string
    {
        if (null === $this->interfaces) {
            return '';
        }

        $interfaceCodes = array_map(fn(TypeGenerator $generator) => $generator->generate(), $this->interfaces);

        return sprintf(' implements %s', join(', ', $interfaceCodes));
    }

    private function generateContent(): string
    {
        $codeParts = [];

        if (count($this->constants)) {
            $code = '';

            foreach ($this->constants as $constant) {
                $code .= sprintf("    %s\n", $constant->generate());
            }

            $codeParts[] = $code;
        }

        if (count($this->properties)) {
            $code = '';

            foreach ($this->properties as $property) {
                $code .= sprintf("    %s\n", $property->generate());
            }

            $codeParts[] = $code;
        }

        if (count($this->methods)) {
            $methodCodes = array_map(fn(MethodGenerator $generator) => $generator->generate(), $this->methods);
            $codeParts[] = join("\n\n", $methodCodes) . "\n";
        }

        return join("\n", $codeParts);
    }

    public function setParentClass(string $parentClass): static
    {
        $this->parentClass = new TypeGenerator($parentClass);

        return $this;
    }

    public function addInterfaces(string ...$interfaces): static
    {
        if (null === $this->interfaces) {
            $this->interfaces = [];
        }

        $interfaceGenerators = array_map(fn(string $interface) => new TypeGenerator($interface), $interfaces);
        $this->interfaces = array_merge($this->interfaces, $interfaceGenerators);

        return $this;
    }

    public function addProperty(string $name, string $visibility): PropertyGenerator
    {
        return $this->properties[] = new PropertyGenerator($name, $visibility);
    }

    public function addConstant(string $name, mixed $value, string $visibility = null): static
    {
        $this->constants[] = new ConstantGenerator($name, $value, $visibility);

        return $this;
    }

    public function addMethod(string $name, string $visibility = null): MethodGenerator
    {
        return $this->methods[] = new MethodGenerator($name, $visibility);
    }
}
