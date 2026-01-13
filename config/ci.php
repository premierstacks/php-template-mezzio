<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;

return (new ConfigAggregator([
    new ArrayProvider([
        PDO::class => [
            'dbname' => '',
            'password' => \getenv('MYSQL_ROOT_PASSWORD_FILE'),
            'username' => 'root',
        ],
        'debug' => true,
    ]),
]))->getMergedConfig();
