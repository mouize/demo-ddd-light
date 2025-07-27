<?php
namespace App\TimeTracking\Domain\Repository;

use App\TimeTracking\Domain\Timesheet;

interface TimesheetRepository
{
    public function save(Timesheet $timesheet): void;
    public function findByUserAndWeek(string $userId, string $weekId): ?Timesheet;
}
