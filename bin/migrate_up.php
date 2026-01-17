<?php

declare(strict_types=1);

use Src\Bootstrap\Bootstrapper;
use Src\Database\Migrations;
use Src\Database\Migrator;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = Bootstrapper::bootstrap();

$migrator = $kernel->container->get(Migrator::class);
$migrations = $kernel->container->get(Migrations::class);

\assert($migrator instanceof Migrator);
\assert($migrations instanceof Migrations);

$migrator->forward($migrations);
