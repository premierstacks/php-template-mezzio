<?php

declare(strict_types=1);

namespace Src\Bootstrap;

use PDO;
use Src\Database\Migrations;
use Src\Database\Migrator;
use Src\Database\PdoConfig;
use Src\Database\PdoConfigInterface;
use Src\Handler\PingHandler;
use Src\Migration\CreateUsersTableMigration;
use Src\Provider\PdoProvider;

final readonly class ConfigProvider
{
    /**
     * @return array<int|string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return array<int|string, mixed>
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                CreateUsersTableMigration::class => CreateUsersTableMigration::class . '::provide',
                Migrations::class => Migrations::class . '::provide',
                Migrator::class => Migrator::class . '::provide',
                PingHandler::class => PingHandler::class . '::provide',
                PdoConfigInterface::class => PdoConfig::class . '::provide',
                PDO::class => PdoProvider::class . '::provide',
            ],
        ];
    }
}
