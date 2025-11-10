<?php

declare(strict_types=1);

use App\ConfigProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

if (\is_readable('data/cache/config-cache.php')) {
    return (new ConfigAggregator([], 'data/cache/config-cache.php'))->getMergedConfig();
}

return (new ConfigAggregator([
    \Mezzio\Router\LaminasRouter\ConfigProvider::class,
    \Laminas\Router\ConfigProvider::class,
    \Laminas\HttpHandlerRunner\ConfigProvider::class,
    \Laminas\Validator\ConfigProvider::class,
    \Mezzio\Helper\ConfigProvider::class,
    \Mezzio\ConfigProvider::class,
    \Mezzio\Router\ConfigProvider::class,
    \Laminas\Diactoros\ConfigProvider::class,
    ConfigProvider::class,
    new PhpFileProvider(\realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),
    new PhpFileProvider(\realpath(__DIR__) . '/development.config.php'),
], 'data/cache/config-cache.php'))->getMergedConfig();
