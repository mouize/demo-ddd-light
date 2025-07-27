<?php
namespace App\TimeTracking\Domain\Enum;

enum TimesheetStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
}
