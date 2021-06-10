<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\FileGenerator;

class FileGeneratorTest extends TestCase
{
    public function testGenerateNothing(): void
    {
        $generator = new FileGenerator();
        self::assertSame("<?php\n", $generator->generate());
    }

    public function testGenerateWithOneGeneratorInConstructor(): void
    {
        $generator = new FileGenerator(new MockGenerator('code'));
        self::assertSame("<?php\n\ncode\n", $generator->generate());
    }

    public function testGenerateWithTwoGeneratorsInConstructor(): void
    {
        $generator = new FileGenerator(
            new MockGenerator('code1'),
            new MockGenerator('code2')
        );

        self::assertSame("<?php\n\ncode1\n\ncode2\n", $generator->generate());
    }

    public function testAddGeneratorsWithOneGenerator(): void
    {
        $generator = (new FileGenerator())
            ->addGenerators(new MockGenerator('code'));

        self::assertSame("<?php\n\ncode\n", $generator->generate());
    }

    public function testAddGeneratorsWithTwoGenerators(): void
    {
        $generator = (new FileGenerator())
            ->addGenerators(
                new MockGenerator('code1'),
                new MockGenerator('code2')
            );

        self::assertSame("<?php\n\ncode1\n\ncode2\n", $generator->generate());
    }

    public function testGeneratorsInConstructorAndInAddGenerators(): void
    {
        $generator = (new FileGenerator(
            new MockGenerator('code1'),
            new MockGenerator('code2')
        ))
            ->addGenerators(
                new MockGenerator('code3'),
                new MockGenerator('code4')
            )
            ->addGenerators(
                new MockGenerator('code5'),
                new MockGenerator('code6')
            );

        self::assertSame("<?php\n\ncode1\n\ncode2\n\ncode3\n\ncode4\n\ncode5\n\ncode6\n", $generator->generate());
    }

    public function testAddBlock(): void
    {
        $generator = new FileGenerator();
        $generator->addBlock()
            ->line('line1')
            ->line('line2');

        self::assertSame("<?php\n\nline1;\nline2;\n", $generator->generate());
    }

    public function testAddFunction(): void
    {
        $generator = new FileGenerator();
        $generator->addFunction('fun');

        $expectedCode = <<<'PHP'
<?php

function fun()
{
}

PHP;

        self::assertSame($expectedCode, $generator->generate());
    }
}
