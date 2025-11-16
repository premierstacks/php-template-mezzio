<?php

declare(strict_types=1);

namespace App\Bootstrap;

use App\Handler\PingHandler;
use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Laminas\Diactoros\ConfigProvider as LaminasDiactorosConfigProvider;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\ConfigProvider as MezioConfigProvider;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\ConfigProvider as MezzioRouterConfigProvider;
use Mezzio\Router\FastRouteRouter\ConfigProvider as MezzioRouterFastRouteRouterConfigProvider;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Container\ContainerInterface;

final readonly class Bootstrap
{
    /**
     * @return array{0: Application, 1: MiddlewareFactory, 2: ContainerInterface}
     */
    public static function bootstrap(): array
    {
        /**
         * @phpstan-ignore-next-line argument.type
         */
        $container = new ServiceManager(self::cached());

        $app = $container->get(Application::class);

        \assert($app instanceof Application);

        $factory = $container->get(MiddlewareFactory::class);

        \assert($factory instanceof MiddlewareFactory);

        self::pipeline($app, $factory, $container);
        self::routes($app, $factory, $container);

        return [$app, $factory, $container];
    }

    /**
     * @return array<array-key, mixed>
     */
    private static function cached(): array
    {
        $cache = new ApcuConfigCache();

        $cached = $cache->get();

        if ($cached !== null) {
            return $cached;
        }

        $fresh = self::config();

        $cache->set($fresh);

        return $fresh;
    }

    /**
     * @return array<array-key, mixed>
     */
    private static function config(): array
    {
        $env = self::env();

        $config = (new ConfigAggregator([
            MezioConfigProvider::class,
            MezzioRouterFastRouteRouterConfigProvider::class,
            MezzioRouterConfigProvider::class,
            LaminasDiactorosConfigProvider::class,
            ConfigProvider::class,
            new PhpFileProvider(\realpath(__DIR__ . '/../../config/') . '/global.php'),
            new PhpFileProvider(\realpath(__DIR__ . '/../../') . '/.env.php'),
            new PhpFileProvider(\realpath(__DIR__ . '/../../config/') . "/{$env}.php"),
            new PhpFileProvider(\realpath(__DIR__ . '/../../') . "/.env.{$env}.php"),
        ]))->getMergedConfig();

        $dependencies = (new ConfigAggregator([
            new ArrayProvider($config),
            new ArrayProvider([
                'dependencies' => [
                    'services' => [
                        'config' => $config,
                    ],
                ],
            ]),
        ]))->getMergedConfig()['dependencies'] ?? [];

        \assert(\is_array($dependencies));

        return $dependencies;
    }

    private static function env(): string
    {
        $env = \getenv('APP_ENV');

        if (!\is_string($env)) {
            throw new \LogicException('APP_ENV');
        }

        return $env;
    }

    private static function pipeline(Application $app, MiddlewareFactory $factory, ContainerInterface $container): void
    {
        $app->pipe(ErrorHandler::class);
        $app->pipe(RouteMiddleware::class);
        $app->pipe(MethodNotAllowedMiddleware::class);
        $app->pipe(DispatchMiddleware::class);
        $app->pipe(NotFoundHandler::class);
    }

    private static function routes(Application $app, MiddlewareFactory $factory, ContainerInterface $container): void
    {
        $app->route(PingHandler::PATH, [PingHandler::class], [PingHandler::METHOD]);
    }
}
