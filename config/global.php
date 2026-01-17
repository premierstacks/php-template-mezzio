<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;

return (new ConfigAggregator([
    new ArrayProvider([
        'APP_ENV' => \getenv('APP_ENV'),
        'debug' => false,
        PDO::class => [
            'dbname' => \getenv('MYSQL_DATABASE'),
            'host' => \getenv('MYSQL_HOST'),
            'options' => [],
            'password' => \getenv('MYSQL_PASSWORD_FILE'),
            'port' => '',
            'socket' => '',
            'username' => \getenv('MYSQL_USER'),
        ],
    ]),
]))->getMergedConfig();
