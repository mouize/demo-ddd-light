<?php
namespace App\TimeTracking\Domain;

use App\Shared\ValueObjects\Week;
use App\Shared\ValueObjects\Duration;
use App\TimeTracking\Domain\Enum\TimesheetStatus;

class Timesheet
{
    public TimesheetStatus $status;

    /**
     * @param array<string, Duration> $dailyDurations
     */
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly Week $week,
        public readonly array $dailyDurations,
    ) {
        $this->status = TimesheetStatus::DRAFT;
    }

    public function totalDuration(): int
    {
        return array_reduce($this->dailyDurations, fn ($carry, Duration $d) => $carry + $d->minutes, 0);
    }

    public function submit(): void
    {
        if ($this->status === TimesheetStatus::SUBMITTED) {
            throw new \DomainException('Timesheet already submitted.');
        }
        $this->status = TimesheetStatus::SUBMITTED;
    }
}
