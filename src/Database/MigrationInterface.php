<?php

declare(strict_types=1);

namespace Src\Database;

interface MigrationInterface
{
    public function selector(): string;

    /**
     * @return iterable<int|string, string>
     */
    public function up(): iterable;
}
