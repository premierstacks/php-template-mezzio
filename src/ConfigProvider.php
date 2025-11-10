<?php

declare(strict_types=1);

namespace App;

use App\Handler\PingHandler;

class ConfigProvider
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
            'invokables' => [
                PingHandler::class => PingHandler::class,
            ],
        ];
    }
}
