<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\BlockGenerator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BlockGeneratorTest extends TestCase
{
    public function testGenerateNothing(): void
    {
        $generator = new BlockGenerator();
        self::assertSame('', $generator->generate());
    }

    public function testLine(): void
    {
        $generator = (new BlockGenerator())
            ->line('line1')
            ->line('line2');

        self::assertSame("line1;\nline2;", $generator->generate());
    }

    public function testRawLine(): void
    {
        $generator = (new BlockGenerator())
            ->rawLine('line1')
            ->rawLine('line2');

        self::assertSame("line1\nline2", $generator->generate());
    }

    public function testIndent(): void
    {
        $generator = (new BlockGenerator())
            ->rawLine('line1')
            ->indent()
            ->rawLine('line2');

        self::assertSame("line1\n    line2", $generator->generate());
    }

    public function testOutdent(): void
    {
        $generator = (new BlockGenerator())
            ->rawLine('line1')
            ->indent()
            ->rawLine('line2')
            ->outdent()
            ->rawLine('line3');

        self::assertSame("line1\n    line2\nline3", $generator->generate());
    }

    public function testOutdentWithoutIndenting(): void
    {
        $generator = (new BlockGenerator())
            ->rawLine('line1')
            ->rawLine('line2')
            ->outdent()
            ->rawLine('line3');

        self::assertSame("line1\nline2\nline3", $generator->generate());
    }

    public function testSetBaseIndentation(): void
    {
        $generator = (new BlockGenerator())
            ->rawLine('line1')
            ->indent()
            ->rawLine('line2')
            ->outdent()
            ->rawLine('line3')
            ->setBaseIndentation(1);

        self::assertSame("    line1\n        line2\n    line3", $generator->generate());

        $generator->setBaseIndentation(2);
        self::assertSame("        line1\n            line2\n        line3", $generator->generate());
    }

    public function testSetMinusBaseIndentation(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Indentation must be positive or 0');
        (new BlockGenerator())->setBaseIndentation(-1);
    }

    public function testBreakLine(): void
    {
        $generator = (new BlockGenerator())
            ->rawLine('line1')
            ->breakLine()
            ->rawLine('line2');

        self::assertSame("line1\n\nline2", $generator->generate());
    }
}
