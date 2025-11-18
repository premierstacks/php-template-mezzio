<?php

declare(strict_types=1);

namespace Tests;

use App\Bootstrap\Bootstrapper;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use PHPUnit\Framework\TestCase as VendorTestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

use function assert;

/**
 * @internal
 */
abstract class TestCase extends VendorTestCase
{
    private Application|null $app = null;

    private ContainerInterface|null $container = null;

    private MiddlewareFactory|null $middleware = null;

    protected function app(): Application
    {
        if ($this->app === null) {
            [$this->app, $this->middleware, $this->container] = Bootstrapper::bootstrap();
        }

        return $this->app;
    }

    protected function container(): ContainerInterface
    {
        if ($this->container === null) {
            [$this->app, $this->middleware, $this->container] = Bootstrapper::bootstrap();
        }

        return $this->container;
    }

    /**
     * @param array<array-key, mixed> $params
     */
    protected function createServerRequest(string $method, UriInterface|string $uri, array $params = []): ServerRequestInterface
    {
        return $this->resolve(ServerRequestFactoryInterface::class)->createServerRequest($method, $uri, $params);
    }

    protected function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->app()->handle($request);
    }

    protected function middleware(): MiddlewareFactory
    {
        if ($this->middleware === null) {
            [$this->app, $this->middleware, $this->container] = Bootstrapper::bootstrap();
        }

        return $this->middleware;
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    protected function resolve(string $class): object
    {
        $resolved = $this->container()->get($class);

        assert($resolved instanceof $class);

        return $resolved;
    }
}
