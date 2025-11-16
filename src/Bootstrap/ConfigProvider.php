<?php

declare(strict_types=1);

namespace App\Bootstrap;

use App\Factory\AdapterInterfaceFactory;
use App\Handler\PingHandler;
use App\RowGateway\UsersRowGateway;
use App\TableGateway\UsersTableGateway;
use Laminas\Db\Adapter\AdapterInterface;

final readonly class ConfigProvider
{
    /**
     * @return array<array-key, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                UsersTableGateway::class => UsersTableGateway::class . '::factory',
                UsersRowGateway::class => UsersRowGateway::class . '::factory',
                PingHandler::class => PingHandler::class . '::factory',
                AdapterInterface::class => AdapterInterfaceFactory::class . '::factory',
            ],
        ];
    }
}
