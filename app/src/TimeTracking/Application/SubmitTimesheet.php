<?php
namespace App\TimeTracking\Application;

use App\TimeTracking\Domain\Timesheet;
use App\TimeTracking\Domain\Repository\TimesheetRepository;
use App\Shared\ValueObjects\Week;
use App\Shared\ValueObjects\Duration;

class SubmitTimesheet
{
    public function __construct(
        private TimesheetRepository $repository,
    ) {}

    public function handle(string $userId, Week $week, array $dailyDurations): void
    {
        $existing = $this->repository->findByUserAndWeek($userId, $week->id());
        if ($existing !== null) {
            throw new \DomainException('Timesheet already submitted for this week.');
        }

        $durations = array_map(fn ($hours) => new Duration($hours), $dailyDurations);

        $timesheet = new Timesheet(
            id: uniqid(),
            userId: $userId,
            week: $week,
            dailyDurations: $durations,
        );

        $this->repository->save($timesheet);
    }
}
