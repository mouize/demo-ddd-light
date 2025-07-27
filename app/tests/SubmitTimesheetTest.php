<?php

use PHPUnit\Framework\TestCase;
use App\TimeTracking\Application\SubmitTimesheet;
use App\TimeTracking\Infrastructure\Persistence\InMemoryTimesheetRepository;
use App\Shared\ValueObjects\Week;

class SubmitTimesheetTest extends TestCase
{
    public function test_submit_timesheet_when_none_exists_given_valid_data_then_it_is_saved(): void
    {
        $repo = new InMemoryTimesheetRepository();
        $useCase = new SubmitTimesheet($repo);

        $week = new Week(27, 2024);

        $useCase->handle(
            userId: 'user-123',
            week: $week,
            dailyDurations: [
                'monday' => 120,
                'tuesday' => 240,
            ]
        );

        $this->assertNotNull($repo->findByUserAndWeek('user-123', $week->id()));
    }

    public function test_submit_timesheet_when_already_exists_given_same_user_and_week_then_it_throws(): void
    {
        $this->expectException(\DomainException::class);

        $repo = new InMemoryTimesheetRepository();
        $useCase = new SubmitTimesheet($repo);
        $week = new Week(27, 2024);

        $useCase->handle('user-123', $week, ['monday' => 60]);
        $useCase->handle('user-123', $week, ['tuesday' => 60]); // should fail
    }
}