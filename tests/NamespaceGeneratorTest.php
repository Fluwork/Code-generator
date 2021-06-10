<?php

namespace Fluwork\CodeGenerator\Tests;

use Fluwork\CodeGenerator\NamespaceGenerator;
use PHPUnit\Framework\TestCase;

class NamespaceGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $generator = new NamespaceGenerator('name\space');
        self::assertSame('namespace name\space;', $generator->generate());
    }
}
