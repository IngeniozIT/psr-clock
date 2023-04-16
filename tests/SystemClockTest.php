<?php

declare(strict_types=1);

namespace IngeniozIT\Clock\Tests;

use PHPUnit\Framework\TestCase;
use IngeniozIT\Clock\SystemClock;
use Psr\Clock\ClockInterface;
use DateTimeImmutable;
use DateTimeZone;

class SystemClockTest extends TestCase
{
    public function testIsAPsrClockImplementation(): void
    {
        $clock = new SystemClock();

        self::assertInstanceOf(ClockInterface::class, $clock);
    }

    public function testReturnsCurrentSystemTime(): void
    {
        $clock = new SystemClock();
        $beforeTime = new DateTimeImmutable();
        usleep(1);
        $currentTime = $clock->now();
        usleep(1);
        $afterTime = new DateTimeImmutable();

        self::assertGreaterThan($beforeTime, $currentTime);
        self::assertGreaterThan($currentTime, $afterTime);
    }

    /**
     * @dataProvider timezonesProvider
     */
    public function testCanUseTimezone(DateTimeZone|string|null $timezone, string $expectedTimezoneName): void
    {
        $clock = new SystemClock($timezone);

        $time = $clock->now();

        $timezoneName = $time->getTimezone()->getName();
        self::assertEquals($expectedTimezoneName, $timezoneName);
    }

    /**
     * @return array<string, array{timezone: DateTimeZone|string|null, expectedTimezoneName: string}>
     */
    public static function timezonesProvider(): array
    {
        $parisTimezone = new DateTimeZone('Europe/Paris');
        $gmtTimezone = new DateTimeZone('GMT');
        return [
            'default timezone' => [
                'timezone' => null,
                'expectedTimezoneName' => date_default_timezone_get()
            ],
            'Europe/Paris DateTimeZone' => [
                'timezone' => $parisTimezone,
                'expectedTimezoneName' => $parisTimezone->getName()
            ],
            'Europe/Paris string' => [
                'timezone' => $parisTimezone->getName(),
                'expectedTimezoneName' => $parisTimezone->getName()
            ],
            'GMT DateTimeZone' => [
                'timezone' => $gmtTimezone,
                'expectedTimezoneName' => $gmtTimezone->getName()
            ],
            'GMT string' => [
                'timezone' => $gmtTimezone->getName(),
                'expectedTimezoneName' => $gmtTimezone->getName()
            ],
        ];
    }
}
