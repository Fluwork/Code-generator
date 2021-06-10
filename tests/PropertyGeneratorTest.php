<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\PropertyGenerator;
use Fluwork\CodeGenerator\RootTypeGenerator;
use Fluwork\CodeGenerator\TypeGenerator;
use Fluwork\CodeGenerator\UnionTypeGenerator;
use Fluwork\CodeGenerator\Visibility;
use PHPUnit\Framework\TestCase;

class PropertyGeneratorTest extends TestCase
{
    public function testSimple(): void
    {
        $generator = new PropertyGenerator('property', Visibility::PUBLIC);
        self::assertSame('public $property;', $generator->generate());
    }

    public function testSetTypeGeneratorWithRootType(): void
    {
        $generator = (new PropertyGenerator('property', Visibility::PUBLIC))
            ->setTypeGenerator(new RootTypeGenerator('type'));

        self::assertSame('public \type $property;', $generator->generate());
    }

    public function testSetTypeGeneratorWithUnionType(): void
    {
        $typeGenerator = new UnionTypeGenerator(
            new TypeGenerator('type1'),
            new TypeGenerator('type2')
        );

        $generator = (new PropertyGenerator('property', Visibility::PUBLIC))
            ->setTypeGenerator($typeGenerator);

        self::assertSame('public \type1|\type2 $property;', $generator->generate());
    }

    public function testSetType(): void
    {
        $generator = (new PropertyGenerator('property', Visibility::PUBLIC))
            ->setType('type');

        self::assertSame('public \type $property;', $generator->generate());
    }

    public function testSetUnionType(): void
    {
        $generator = (new PropertyGenerator('property', Visibility::PUBLIC))
            ->setUnionType('type1', 'type2');

        self::assertSame('public \type1|\type2 $property;', $generator->generate());
    }

    public function testSetDefault(): void
    {
        $generator = (new PropertyGenerator('property', Visibility::PUBLIC))
            ->setDefault('default');

        self::assertSame("public \$property = 'default';", $generator->generate());
    }
}
