<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\ParameterGenerator;
use Fluwork\CodeGenerator\ParametersGenerator;
use PHPUnit\Framework\TestCase;

class ParametersGeneratorTest extends TestCase
{
    public function testOneParameter(): void
    {
        $generator = new ParametersGenerator(new ParameterGenerator('parameter'));
        self::assertSame('$parameter', $generator->generate());
    }

    public function testTwoParameters(): void
    {
        $generator = new ParametersGenerator(
            new ParameterGenerator('parameter1'),
            new ParameterGenerator('parameter2')
        );

        self::assertSame('$parameter1, $parameter2', $generator->generate());
    }
}
