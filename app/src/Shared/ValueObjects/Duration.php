<?php
namespace App\Shared\ValueObjects;

class Duration
{
    public function __construct(public readonly int $minutes)
    {
        if ($minutes < 0) {
            throw new \InvalidArgumentException('Duration must be >= 0');
        }
    }
}
