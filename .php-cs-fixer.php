<?php

declare(strict_types=1);

use Premierstacks\PhpCsFixerStack\ConfigFactory;
use Premierstacks\PhpCsFixerStack\FinderFactory;
use Premierstacks\PhpCsFixerStack\PHP83;

return ConfigFactory::make(FinderFactory::make()->in(__DIR__), \array_replace(
    PHP83::recommended(new DateTimeImmutable()),
    PHP83::project(new DateTimeImmutable()),
));
