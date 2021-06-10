<?php

namespace Fluwork\CodeGenerator;

use InvalidArgumentException;

class BlockGenerator implements GeneratorInterface
{
    private array $lines = [];
    private int $indentation = 0;
    private int $baseIndentation = 0;

    public function generate(): string
    {
        $lines = array_map(
            fn(string $line) => sprintf('%s%s', $this->generateIndentationSpaces($this->baseIndentation), $line),
            $this->lines
        );

        return join("\n", $lines);
    }

    private function generateIndentationSpaces(int $indentation): string
    {
        return str_repeat('    ', $indentation);
    }

    public function line(string $line): self
    {
        return $this->rawLine(sprintf('%s;', $line));
    }

    public function rawLine(string $line): static
    {
        $this->lines[] = sprintf('%s%s', $this->generateIndentationSpaces($this->indentation), $line);

        return $this;
    }

    public function indent(): static
    {
        $this->indentation++;

        return $this;
    }

    public function outdent(): static
    {
        if (0 !== $this->indentation) {
            $this->indentation--;
        }

        return $this;
    }

    public function setBaseIndentation(int $indentation): static
    {
        if ($indentation < 0) {
            throw new InvalidArgumentException('Indentation must be positive or 0');
        }

        $this->baseIndentation = $indentation;

        return $this;
    }

    public function breakLine(): self
    {
        return $this->rawLine('');
    }
}
