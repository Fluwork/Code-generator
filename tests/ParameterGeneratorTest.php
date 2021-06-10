<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\ParameterGenerator;
use Fluwork\CodeGenerator\RootTypeGenerator;
use Fluwork\CodeGenerator\TypeGenerator;
use Fluwork\CodeGenerator\UnionTypeGenerator;
use Fluwork\CodeGenerator\ValueGenerator;
use Fluwork\CodeGenerator\Visibility;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParameterGeneratorTest extends TestCase
{
    public function testParameterName(): void
    {
        $generator = new ParameterGenerator('parameter');
        self::assertSame('$parameter', $generator->generate());
    }

    public function testParameterNameAndRootType(): void
    {
        $generator = new ParameterGenerator('parameter', new RootTypeGenerator('type'));
        self::assertSame('type $parameter', $generator->generate());
    }

    public function testParameterNameAndUnionType(): void
    {
        $typeGenerator = new UnionTypeGenerator(
            new TypeGenerator('type1'),
            new TypeGenerator('type2')
        );

        $generator = new ParameterGenerator('parameter', $typeGenerator);
        self::assertSame('type1|type2 $parameter', $generator->generate());
    }

    public function testParameterNameAndDefault(): void
    {
        $generator = new ParameterGenerator('parameter', null, new ValueGenerator('default'));
        self::assertSame("\$parameter = 'default'", $generator->generate());
    }

    public function testParameterNameAndPropertyPromotion(): void
    {
        $generator = new ParameterGenerator('parameter', null, null, Visibility::PUBLIC);
        self::assertSame('public $parameter', $generator->generate());
    }

    public function testParameterNameAndPropertyPromotionAndRootType(): void
    {
        $generator = new ParameterGenerator('parameter', new RootTypeGenerator('type'), null, Visibility::PUBLIC);
        self::assertSame('public type $parameter', $generator->generate());
    }

    public function testParameterNameAndVariadic(): void
    {
        $generator = new ParameterGenerator('parameter', null, null, null, true);
        self::assertSame('...$parameter', $generator->generate());
    }

    public function testIncompatiblePropertyPromotionAndVariadic(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot declare variadic promoted property');
        new ParameterGenerator('parameter', null, null, Visibility::PUBLIC, true);
    }
}
