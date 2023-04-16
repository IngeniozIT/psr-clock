<?php

declare(strict_types=1);

namespace IngeniozIT\Clock;

use Psr\Clock\ClockInterface;
use DateTimeImmutable;

readonly class FrozenClock implements ClockInterface
{
    public function __construct(
        private DateTimeImmutable $now
    ) {
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
