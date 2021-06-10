<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\BlockGenerator;
use Fluwork\CodeGenerator\MethodGenerator;
use Fluwork\CodeGenerator\ParameterGenerator;
use Fluwork\CodeGenerator\ParametersGenerator;
use Fluwork\CodeGenerator\RootTypeGenerator;
use Fluwork\CodeGenerator\TypeGenerator;
use Fluwork\CodeGenerator\UnionTypeGenerator;
use Fluwork\CodeGenerator\Visibility;
use LogicException;

class MethodGeneratorTest extends TestCase
{
    public function testSimple(): void
    {
        $expectedCode = <<<PHP
    function method()
    {
    }
PHP;

        $generator = new MethodGenerator('method');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSimpleWithVisibility(): void
    {
        $expectedCode = <<<PHP
    public function method()
    {
    }
PHP;

        $generator = new MethodGenerator('method', Visibility::PUBLIC);
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testContentCreatedAutomatically(): void
    {
        $expectedCode = <<<PHP
    function method()
    {
        line;
    }
PHP;

        $generator = new MethodGenerator('method');
        $generator->getContent()
            ->line('line');

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetContent(): void
    {
        $expectedCode = <<<PHP
    function method()
    {
        line;
    }
PHP;

        $content = (new BlockGenerator())->line('line');
        $generator = (new MethodGenerator('method'))->setContent($content);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnTypeGeneratorWithRootType(): void
    {
        $expectedCode = <<<'PHP'
    function method(): \type
    {
    }
PHP;

        $generator = (new MethodGenerator('method'))
            ->setReturnTypeGenerator(new RootTypeGenerator('type'));

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnTypeGeneratorWithUnionType(): void
    {
        $expectedCode = <<<'PHP'
    function method(): \type1|\type2
    {
    }
PHP;

        $returnTypeGenerator = new UnionTypeGenerator(
            new TypeGenerator('type1'),
            new TypeGenerator('type2')
        );

        $generator = (new MethodGenerator('method'))
            ->setReturnTypeGenerator($returnTypeGenerator);

        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnType(): void
    {
        $expectedCode = <<<'PHP'
    function method(): \type
    {
    }
PHP;

        $generator = (new MethodGenerator('method'))->setReturnType('type');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetReturnUnionType(): void
    {
        $expectedCode = <<<'PHP'
    function method(): \type1|\type2
    {
    }
PHP;

        $generator = (new MethodGenerator('method'))->setReturnUnionType('type1', 'type2');
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetParameters(): void
    {
        $expectedCode = <<<'PHP'
    function method($parameter)
    {
    }
PHP;

        $parameters = new ParametersGenerator(new ParameterGenerator('parameter'));
        $generator = (new MethodGenerator('method'))->setParameters($parameters);
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetAbstract(): void
    {
        $expectedCode = <<<PHP
    abstract function method()
PHP;

        $generator = (new MethodGenerator('method'))->setAbstract();
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetFinal(): void
    {
        $expectedCode = <<<PHP
    final function method()
    {
    }
PHP;

        $generator = (new MethodGenerator('method'))->setFinal();
        self::assertSame($expectedCode, $generator->generate());
    }

    public function testSetAbstractAndFinal(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Cannot declare abstract and final method');
        (new MethodGenerator('method'))->setAbstract()->setFinal();
    }

    public function testSetFinalAndAbstract(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Cannot declare abstract and final method');
        (new MethodGenerator('method'))->setFinal()->setAbstract();
    }
}
