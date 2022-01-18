<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class DummyTest extends TestCase
{
    public function testNothing(): void
    {
        self::assertTrue(1 < 3);
    }
}
