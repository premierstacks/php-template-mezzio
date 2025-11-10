<?php

declare(strict_types=1);

\chdir(__DIR__ . '/../');

$path = 'data/cache/config-cache.php';

if (!\is_file($path)) {
    exit(0);
}

if (!\unlink($path)) {
    exit(1);
}

exit(0);
