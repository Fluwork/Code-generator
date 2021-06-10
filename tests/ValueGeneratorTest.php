<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\ValueGenerator;
use PHPUnit\Framework\TestCase;

class ValueGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $generator = new ValueGenerator('value');
        self::assertSame("'value'", $generator->generate());
    }
}
