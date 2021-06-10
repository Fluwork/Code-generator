<?php

namespace Fluwork\CodeGenerator\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @psalm-suppress MissingParamType
     */
    public static function assertSame($expected, $actual, string $message = ''): void
    {
        if (is_string($expected) && is_string($actual)) {
            $expected = str_replace("\r\n", "\n", $expected);
            $actual = str_replace("\r\n", "\n", $actual);
        }

        parent::assertSame($expected, $actual, $message);
    }
}
