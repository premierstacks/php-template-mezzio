<?php

declare(strict_types=1);

use App\Handler\PingHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/api/v1/ping', PingHandler::class);
};
