<?php

namespace Fluwork\CodeGenerator;

use LogicException;

class MethodGenerator extends InterfaceMethodGenerator
{
    private ?BlockGenerator $content = null;
    private bool $abstract = false;
    private bool $final = false;

    public function getContent(): BlockGenerator
    {
        if (null === $this->content) {
            $this->content = new BlockGenerator();
        }

        return $this->content;
    }

    public function setContent(BlockGenerator $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function generate(): string
    {
        $code = '    ';

        if ($this->abstract) {
            $code .= 'abstract ';
        }

        if ($this->final) {
            $code .= 'final ';
        }

        if (null !== $this->visibility) {
            $code .= sprintf('%s ', $this->visibility);
        }

        $code .= sprintf('function %s(', $this->name);

        if (null !== $this->parameters) {
            $code .= $this->parameters->generate();
        }

        $code .= ')';

        if (null !== $this->returnType) {
            $code .= sprintf(': %s', $this->returnType->generate());
        }

        if ($this->abstract) {
            return $code . ';';
        }

        $code .= "\n    {\n";

        if (null !== $this->content) {
            $code .= sprintf("%s\n", $this->content->setBaseIndentation(2)->generate());
        }

        return $code . '    }';
    }

    public function setAbstract(): static
    {
        if ($this->final) {
            throw new LogicException('Cannot declare abstract and final method');
        }

        $this->abstract = true;

        return $this;
    }

    public function setFinal(): static
    {
        if ($this->abstract) {
            throw new LogicException('Cannot declare abstract and final method');
        }

        $this->final = true;

        return $this;
    }
}
