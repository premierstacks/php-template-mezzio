<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;

return (new ConfigAggregator([
    new ArrayProvider([
        'debug' => true,
    ]),
]))->getMergedConfig();
