<?php

use Bramus\Router\Router;
use App\TimeTracking\Application\Http\TimesheetController;

$router = new Router();

// Create a new timesheet
$router->post('/timesheets', [TimesheetController::class, 'submit']);

// Submit an existing timesheet for approval
$router->post('/timesheets/(\d{1,2})/(\d{4})/submit', function ($week, $year) {
    TimesheetController::submitForApproval($week, $year);
});

// Start routing
$router->run();
