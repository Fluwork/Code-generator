<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\TypeGenerator;
use PHPUnit\Framework\TestCase;

class TypeGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $generator = new TypeGenerator('type');
        self::assertSame('type', $generator->generate());
    }
}
