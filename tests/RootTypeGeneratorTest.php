<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\RootTypeGenerator;
use PHPUnit\Framework\TestCase;

class RootTypeGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $generator = new RootTypeGenerator('type');
        self::assertSame('\type', $generator->generate());
    }

    public function testGenerateWithNullable(): void
    {
        $generator = new RootTypeGenerator('type', true);
        self::assertSame('?\type', $generator->generate());
    }
}
