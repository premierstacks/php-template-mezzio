<?php

declare(strict_types=1);

namespace Tests;

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use PHPUnit\Framework\TestCase as VendorTestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @internal
 */
abstract class TestCase extends VendorTestCase
{
    public Application $app;

    public ContainerInterface $container;

    public MiddlewareFactory $middleware;

    protected function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->app->handle($request);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    protected function inject(string $class): object
    {
        $resolved = $this->resolve($class);

        \assert($resolved instanceof $class);

        return $resolved;
    }

    /**
     * @param array<array-key, mixed> $params
     */
    protected function request(string $method, UriInterface|string $uri, array $params = []): ServerRequestInterface
    {
        return $this->inject(ServerRequestFactoryInterface::class)->createServerRequest($method, $uri, $params);
    }

    protected function resolve(string $id): mixed
    {
        return $this->container->get($id);
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $bootstrap = require __DIR__ . '/../config/bootstrap.php';

        \assert(\is_array($bootstrap));
        \assert(isset($bootstrap[0]) && $bootstrap[0] instanceof Application);
        \assert(isset($bootstrap[1]) && $bootstrap[1] instanceof MiddlewareFactory);
        \assert(isset($bootstrap[2]) && $bootstrap[2] instanceof ContainerInterface);

        [$this->app, $this->middleware, $this->container] = $bootstrap;
    }
}
