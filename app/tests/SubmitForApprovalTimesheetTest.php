<?php

use App\TimeTracking\Domain\Enum\TimesheetStatus;
use PHPUnit\Framework\TestCase;
use App\TimeTracking\Application\SubmitForApproval;
use App\TimeTracking\Application\SubmitTimesheet;
use App\TimeTracking\Infrastructure\Persistence\InMemoryTimesheetRepository;
use App\Shared\ValueObjects\Week;

class SubmitForApprovalTimesheetTest extends TestCase
{
    public function test_submit_for_approval_timesheet_when_it_is_draft_given_valid_user_and_week_then_it_is_submitted(): void
    {
        $repo = new InMemoryTimesheetRepository();
        $week = new Week(27, 2024);

        $creator = new SubmitTimesheet($repo);
        $creator->handle('user-123', $week, ['monday' => 60]);

        $submitter = new SubmitForApproval($repo);
        $submitter->handle('user-123', $week->id());

        $timesheet = $repo->findByUserAndWeek('user-123', $week->id());

        $this->assertEquals(TimesheetStatus::SUBMITTED->value, $timesheet->status->value);
    }

    public function test_submit_for_approval_timesheet_when_already_submitted_then_it_throws(): void
    {
        $this->expectException(\DomainException::class);

        $repo = new InMemoryTimesheetRepository();
        $week = new Week(27, 2024);

        $creator = new SubmitTimesheet($repo);
        $creator->handle('user-123', $week, ['monday' => 60]);

        $submitter = new SubmitForApproval($repo);
        $submitter->handle('user-123', $week->id());
        $submitter->handle('user-123', $week->id()); // second call should throw
    }
}