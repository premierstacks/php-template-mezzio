<?php

declare(strict_types=1);

namespace App\RowGateway;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\RowGateway\RowGateway;
use Psr\Container\ContainerInterface;

/**
 * @property int $id
 */
final class UsersRowGateway extends RowGateway
{
    public static function factory(ContainerInterface $container): self
    {
        $adapter = $container->get(AdapterInterface::class);

        \assert($adapter instanceof AdapterInterface);

        return new self('id', 'users', $adapter);
    }
}
