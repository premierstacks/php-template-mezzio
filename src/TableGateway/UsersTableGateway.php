<?php

declare(strict_types=1);

namespace App\TableGateway;

use App\RowGateway\UsersRowGateway;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\Feature\RowGatewayFeature;
use Laminas\Db\TableGateway\TableGateway;
use Psr\Container\ContainerInterface;

final class UsersTableGateway extends TableGateway
{
    public static function factory(ContainerInterface $container): self
    {
        $adapter = $container->get(AdapterInterface::class);

        \assert($adapter instanceof AdapterInterface);

        $row = $container->get(UsersRowGateway::class);

        \assert($row instanceof UsersRowGateway);

        return new self('users', $adapter, new RowGatewayFeature($row));
    }
}
