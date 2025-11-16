<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;

final readonly class AdapterInterfaceFactory
{
    public static function factory(ContainerInterface $container): AdapterInterface
    {
        $config = $container->get('config');

        \assert(\is_array($config));

        $db = $config['db'] ?? null;

        \assert(\is_array($db));

        return new Adapter($db);
    }
}
