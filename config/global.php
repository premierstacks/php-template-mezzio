<?php

declare(strict_types=1);

namespace Config;

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;

use function getenv;
use function in_array;

return (new ConfigAggregator([
    new ArrayProvider([
        'debug' => in_array(getenv('APP_ENV'), ['local', 'ci'], true),
        'db' => [
            'driver' => 'Pdo_Mysql',
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
        ],
    ]),
]))->getMergedConfig();
