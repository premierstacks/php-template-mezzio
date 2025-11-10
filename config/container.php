<?php

declare(strict_types=1);

use Laminas\ServiceManager\ServiceManager;

$config = require __DIR__ . '/config.php';

\assert(\is_array($config));
\assert(isset($config['dependencies']));

$dependencies = $config['dependencies'];

\assert(\is_array($dependencies));
\assert(isset($dependencies['services']) && \is_array($dependencies['services']));

$dependencies['services']['config'] = $config;

/**
 * @phpstan-ignore-next-line argument.type
 */
return new ServiceManager($dependencies);
