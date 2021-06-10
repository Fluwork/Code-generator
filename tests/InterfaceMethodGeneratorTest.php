<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\InterfaceMethodGenerator;
use Fluwork\CodeGenerator\ParameterGenerator;
use Fluwork\CodeGenerator\ParametersGenerator;
use Fluwork\CodeGenerator\RootTypeGenerator;
use Fluwork\CodeGenerator\TypeGenerator;
use Fluwork\CodeGenerator\UnionTypeGenerator;
use Fluwork\CodeGenerator\Visibility;

class InterfaceMethodGeneratorTest extends TestCase
{
    public function testSimple(): void
    {
        $generator = new InterfaceMethodGenerator('method');
        self::assertSame('    function method();', $generator->generate());
    }

    public function testSimpleWithVisibility(): void
    {
        $generator = new InterfaceMethodGenerator('method', Visibility::PUBLIC);
        self::assertSame('    public function method();', $generator->generate());
    }

    public function testSetReturnTypeGeneratorWithRootType(): void
    {
        $generator = (new InterfaceMethodGenerator('method'))
            ->setReturnTypeGenerator(new RootTypeGenerator('type'));

        self::assertSame('    function method(): \type;', $generator->generate());
    }

    public function testSetReturnTypeGeneratorWithUnionType(): void
    {
        $returnTypeGenerator = new UnionTypeGenerator(
            new TypeGenerator('type1'),
            new TypeGenerator('type2')
        );

        $generator = (new InterfaceMethodGenerator('method'))
            ->setReturnTypeGenerator($returnTypeGenerator);

        self::assertSame('    function method(): \type1|\type2;', $generator->generate());
    }

    public function testSetReturnType(): void
    {
        $generator = (new InterfaceMethodGenerator('method'))->setReturnType('type');
        self::assertSame('    function method(): \type;', $generator->generate());
    }

    public function testSetReturnUnionType(): void
    {
        $generator = (new InterfaceMethodGenerator('method'))->setReturnUnionType('type1', 'type2');
        self::assertSame('    function method(): \type1|\type2;', $generator->generate());
    }

    public function testSetParameters(): void
    {
        $parameters = new ParametersGenerator(new ParameterGenerator('parameter'));
        $generator = (new InterfaceMethodGenerator('method'))->setParameters($parameters);
        self::assertSame('    function method($parameter);', $generator->generate());
    }
}
