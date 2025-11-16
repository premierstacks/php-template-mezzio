<?php

declare(strict_types=1);

namespace App\Bootstrap;

final readonly class ApcuConfigCache
{
    /**
     * @return array<array-key, mixed>|null
     */
    public function get(): array|null
    {
        if (!$this->enabled()) {
            return null;
        }

        $ok = false;
        $resolved = \apcu_fetch($this->key(), $ok);

        if ($ok && \is_array($resolved)) {
            return $resolved;
        }

        return null;
    }

    /**
     * @param array<array-key, mixed> $config
     */
    public function set(array $config): void
    {
        if (!$this->enabled()) {
            return;
        }

        $ok = \apcu_store($this->key(), $config);

        if ($ok !== true) {
            throw new \UnexpectedValueException('apcu_store');
        }
    }

    private function enabled(): bool
    {
        return \apcu_enabled() && \PHP_SAPI !== 'cli' && \PHP_SAPI !== 'cli-server' && \PHP_SAPI !== 'phpdbg';
    }

    private function key(): string
    {
        return self::class;
    }
}
