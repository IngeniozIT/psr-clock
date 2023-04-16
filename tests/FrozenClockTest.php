<?php

declare(strict_types=1);

namespace IngeniozIT\Clock\Tests;

use PHPUnit\Framework\TestCase;
use IngeniozIT\Clock\FrozenClock;
use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class FrozenClockTest extends TestCase
{
    public function testIsAPsrClockImplementation(): void
    {
        $clock = new FrozenClock(new DateTimeImmutable());

        self::assertInstanceOf(ClockInterface::class, $clock);
    }

    public function testReturnsFrozenTime(): void
    {
        $expectedTime = new DateTimeImmutable('2022-11-26');
        $clock = new FrozenClock($expectedTime);

        $currentTime = $clock->now();

        self::assertEquals($expectedTime, $currentTime);
    }
}
