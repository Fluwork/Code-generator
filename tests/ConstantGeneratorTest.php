<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\ConstantGenerator;
use Fluwork\CodeGenerator\Visibility;
use PHPUnit\Framework\TestCase;

class ConstantGeneratorTest extends TestCase
{
    public function testWithNoVisibility(): void
    {
        $generator = new ConstantGenerator('constant', 'value');
        self::assertSame("const constant = 'value';", $generator->generate());
    }

    public function testWithVisibility(): void
    {
        $generator = new ConstantGenerator('constant', 'value', Visibility::PUBLIC);
        self::assertSame("public const constant = 'value';", $generator->generate());
    }
}
