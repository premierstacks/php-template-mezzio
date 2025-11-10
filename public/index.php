<?php

declare(strict_types=1);

use Mezzio\Application;

if (\PHP_SAPI === 'cli-server' && isset($_SERVER['SCRIPT_FILENAME']) && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

\chdir(\dirname(__DIR__));

require 'vendor/autoload.php';

(static function (): void {
    $bootstrap = require 'config/bootstrap.php';

    \assert(\is_array($bootstrap));
    \assert(isset($bootstrap[0]) && $bootstrap[0] instanceof Application);

    $bootstrap[0]->run();
})();
