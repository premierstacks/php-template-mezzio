<?php

declare(strict_types=1);

use Src\Bootstrap\Bootstrapper;
use Src\Database\Migrations;
use Src\Database\Migrator;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = Bootstrapper::bootstrap();

$migrations = $kernel->container->get(Migrations::class);
$migrator = $kernel->container->get(Migrator::class);

\assert($migrations instanceof Migrations);
\assert($migrator instanceof Migrator);

$migrator->forward($migrations);
