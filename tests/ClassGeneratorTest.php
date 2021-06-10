<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\ClassGenerator;
use Fluwork\CodeGenerator\Visibility;
use LogicException;

class ClassGeneratorTest extends TestCase
{
    public function testSimpleClass(): void
    {
        $expectedCode = <<<PHP
class name
{
}
PHP;

        $generator = new ClassGenerator('name');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetParentClass(): void
    {
        $expectedCode = <<<PHP
class name extends parent
{
}
PHP;

        $generator = (new ClassGenerator('name'))->setParentClass('parent');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testAddInterfaces(): void
    {
        $expectedCode = <<<PHP
class name implements interface1, interface2
{
}
PHP;

        $generator = (new ClassGenerator('name'))->addInterfaces('interface1', 'interface2');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testAddOneProperty(): void
    {
        $expectedCode = <<<'PHP'
class name
{
    public $property;
}
PHP;

        $generator = new ClassGenerator('name');
        $generator->addProperty('property', Visibility::PUBLIC);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testAddTwoProperties(): void
    {
        $expectedCode = <<<'PHP'
class name
{
    public $property1;
    public $property2;
}
PHP;

        $generator = new ClassGenerator('name');
        $generator->addProperty('property1', Visibility::PUBLIC);
        $generator->addProperty('property2', Visibility::PUBLIC);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testAddOneConstant(): void
    {
        $expectedCode = <<<'PHP'
class name
{
    const constant = 'value';
}
PHP;

        $generator = (new ClassGenerator('name'))->addConstant('constant', 'value');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testAddTwoConstants(): void
    {
        $expectedCode = <<<'PHP'
class name
{
    const constant1 = 'value1';
    public const constant2 = 'value2';
}
PHP;

        $generator = (new ClassGenerator('name'))
            ->addConstant('constant1', 'value1')
            ->addConstant('constant2', 'value2', Visibility::PUBLIC);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetAbstract(): void
    {
        $expectedCode = <<<PHP
abstract class name
{
}
PHP;

        $generator = (new ClassGenerator('name'))->setAbstract();
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testConstantsAndProperties(): void
    {
        $expectedCode = <<<'PHP'
class name
{
    const constant = 'value';

    public $property;
}
PHP;

        $generator = (new ClassGenerator('name'))
            ->addConstant('constant', 'value');
        $generator->addProperty('property', Visibility::PUBLIC);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetFinal(): void
    {
        $expectedCode = <<<PHP
final class name
{
}
PHP;

        $generator = (new ClassGenerator('name'))->setFinal();
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetAbstractAndFinal(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Cannot declare abstract and final class');
        (new ClassGenerator('name'))->setAbstract()->setFinal();
    }

    public function testSetFinalAndAbstract(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Cannot declare abstract and final class');
        (new ClassGenerator('name'))->setFinal()->setAbstract();
    }

    public function testAddOneMethod(): void
    {
        $expectedCode = <<<PHP
class name
{
    function method()
    {
    }
}
PHP;

        $generator = new ClassGenerator('name');
        $generator->addMethod('method');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testAddTwoMethods(): void
    {
        $expectedCode = <<<PHP
class name
{
    function method1()
    {
    }

    public function method2()
    {
    }
}
PHP;

        $generator = new ClassGenerator('name');
        $generator->addMethod('method1');
        $generator->addMethod('method2', Visibility::PUBLIC);
        self::assertSame($expectedCode, $generator->generate());
    }
}
