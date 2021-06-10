<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\TypeGenerator;
use Fluwork\CodeGenerator\UnionTypeGenerator;
use PHPUnit\Framework\TestCase;

class UnionTypeGeneratorTest extends TestCase
{
    public function testOneType(): void
    {
        $generator = new UnionTypeGenerator(new TypeGenerator('type'));
        self::assertSame('\type', $generator->generate());
    }

    public function testTwoTypes(): void
    {
        $generator = new UnionTypeGenerator(
            new TypeGenerator('type1'),
            new TypeGenerator('type2')
        );

        self::assertSame('\type1|\type2', $generator->generate());
    }
}
