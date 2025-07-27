<?php
namespace App\TimeTracking\Application;

use App\TimeTracking\Domain\Repository\TimesheetRepository;

class SubmitForApproval
{
    public function __construct(private TimesheetRepository $repository) {}

    public function handle(string $userId, string $weekId): void
    {
        $timesheet = $this->repository->findByUserAndWeek($userId, $weekId);
        if (!$timesheet) {
            throw new \DomainException('Timesheet not found.');
        }
        $timesheet->submit();
        $this->repository->save($timesheet);
    }
}
