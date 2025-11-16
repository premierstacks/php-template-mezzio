<?php

declare(strict_types=1);

use App\Bootstrap\Bootstrap;

require_once __DIR__ . '/../vendor/autoload.php';

\chdir(__DIR__ . '/../');

Bootstrap::bootstrap()[0]->run();
