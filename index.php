<?php

declare(strict_types=1);

use Src\Bootstrap\Bootstrapper;

require_once __DIR__ . '/vendor/autoload.php';

Bootstrapper::bootstrap()->app->run();
