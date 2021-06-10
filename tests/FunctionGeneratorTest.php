<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\BlockGenerator;
use Fluwork\CodeGenerator\FunctionGenerator;
use Fluwork\CodeGenerator\ParameterGenerator;
use Fluwork\CodeGenerator\ParametersGenerator;
use Fluwork\CodeGenerator\RootTypeGenerator;
use Fluwork\CodeGenerator\TypeGenerator;
use Fluwork\CodeGenerator\UnionTypeGenerator;

class FunctionGeneratorTest extends TestCase
{
    public function testGenerateSimpleFunction(): void
    {
        $expectedCode = <<<PHP
function fun()
{
}
PHP;

        $generator = new FunctionGenerator('fun');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testContentCreatedAutomatically(): void
    {
        $expectedCode = <<<PHP
function fun()
{
    line;
}
PHP;

        $generator = new FunctionGenerator('fun');
        $generator->getContent()
            ->line('line');

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetContent(): void
    {
        $expectedCode = <<<PHP
function fun()
{
    line;
}
PHP;

        $content = (new BlockGenerator())->line('line');
        $generator = (new FunctionGenerator('fun'))->setContent($content);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnTypeGeneratorWithRootType(): void
    {
        $expectedCode = <<<PHP
function fun(): type
{
}
PHP;

        $generator = (new FunctionGenerator('fun'))
            ->setReturnTypeGenerator(new RootTypeGenerator('type'));

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnTypeGeneratorWithUnionType(): void
    {
        $expectedCode = <<<PHP
function fun(): type1|type2
{
}
PHP;

        $returnTypeGenerator = new UnionTypeGenerator(
            new TypeGenerator('type1'),
            new TypeGenerator('type2')
        );

        $generator = (new FunctionGenerator('fun'))
            ->setReturnTypeGenerator($returnTypeGenerator);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnType(): void
    {
        $expectedCode = <<<PHP
function fun(): type
{
}
PHP;

        $generator = (new FunctionGenerator('fun'))->setReturnType('type');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnUnionType(): void
    {
        $expectedCode = <<<PHP
function fun(): type1|type2
{
}
PHP;

        $generator = (new FunctionGenerator('fun'))->setReturnUnionType('type1', 'type2');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetParameters(): void
    {
        $expectedCode = <<<'PHP'
function fun($parameter)
{
}
PHP;

        $parameters = new ParametersGenerator(new ParameterGenerator('parameter'));
        $generator = (new FunctionGenerator('fun'))->setParameters($parameters);
        self::assertSame($expectedCode, $generator->generate());
    }
}
