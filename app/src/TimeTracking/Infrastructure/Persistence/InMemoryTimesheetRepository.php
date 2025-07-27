<?php
namespace App\TimeTracking\Infrastructure\Persistence;

use App\TimeTracking\Domain\Repository\TimesheetRepository;
use App\TimeTracking\Domain\Timesheet;

class InMemoryTimesheetRepository implements TimesheetRepository
{
    private array $storage = [];

    public function save(Timesheet $timesheet): void
    {
        $key = $timesheet->userId . '-' . $timesheet->week->id();
        $this->storage[$key] = $timesheet;
    }

    public function findByUserAndWeek(string $userId, string $weekId): ?Timesheet
    {
        $key = $userId . '-' . $weekId;
        return $this->storage[$key] ?? null;
    }
}
