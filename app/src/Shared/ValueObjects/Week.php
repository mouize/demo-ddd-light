<?php
namespace App\Shared\ValueObjects;

class Week
{
    public function __construct(
        public readonly int $weekNumber,
        public readonly int $year,
    ) {
        if ($weekNumber < 1 || $weekNumber > 53) {
            throw new \InvalidArgumentException('Invalid week number.');
        }
    }

    public function id(): string
    {
        return sprintf('%d-W%02d', $this->year, $this->weekNumber);
    }
}
