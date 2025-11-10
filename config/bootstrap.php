<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

$container = require __DIR__ . '/container.php';

\assert($container instanceof ContainerInterface);

$app = $container->get(Application::class);

\assert($app instanceof Application);

$factory = $container->get(MiddlewareFactory::class);

\assert($factory instanceof MiddlewareFactory);

$pipeline = require __DIR__ . '/pipeline.php';

\assert(\is_callable($pipeline));

$routes = require __DIR__ . '/routes.php';

\assert(\is_callable($routes));

$pipeline($app, $factory, $container);
$routes($app, $factory, $container);

return [$app, $factory, $container];
