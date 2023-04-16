<?php

declare(strict_types=1);

namespace IngeniozIT\Clock;

use Psr\Clock\ClockInterface;
use DateTimeZone;
use DateTimeImmutable;

readonly class SystemClock implements ClockInterface
{
    private ?DateTimeZone $timezone;

    public function __construct(DateTimeZone|string|null $timezone = null)
    {
        $this->timezone = is_string($timezone) ? new DateTimeZone($timezone) : $timezone;
    }

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable('now', $this->timezone);
    }
}
