<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\TypeGenerator;
use Generator;
use PHPUnit\Framework\TestCase;

class TypeGeneratorTest extends TestCase
{
    /**
     * @dataProvider provideTypes
     */
    public function testGenerate(string $type, string $expected): void
    {
        $generator = new TypeGenerator($type);
        self::assertSame($expected, $generator->generate());
    }

    public function provideTypes(): Generator
    {
        yield ['type', '\type'];
        yield ['bool', 'bool'];
        yield ['int', 'int'];
        yield ['float', 'float'];
        yield ['string', 'string'];
        yield ['array', 'array'];
        yield ['iterable', 'iterable'];
        yield ['void', 'void'];
        yield ['null', 'null'];
        yield ['object', 'object'];
        yield ['callable', 'callable'];
    }
}
