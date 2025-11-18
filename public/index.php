<?php

declare(strict_types=1);

use App\Bootstrap\Bootstrapper;

require_once __DIR__ . '/../vendor/autoload.php';

\chdir(__DIR__ . '/../');

Bootstrapper::bootstrap()[0]->run();
