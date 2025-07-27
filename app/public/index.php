<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application\Command\RegisterUserHandler;
use App\Infrastructure\Persistence\InMemory\InMemoryUserRepository;

$repository = new InMemoryUserRepository();
$handler = new RegisterUserHandler($repository);

$handler->handle('test@example.com', 'Test User');

echo "User registered!";
