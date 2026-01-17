<?php

/**
 * @author Tomáš Chochola <tomaschochola@seznam.cz>
 * @copyright © 2025 Tomáš Chochola <tomaschochola@seznam.cz>
 *
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomaschochola} GitHub Profile
 * @see {@link https://github.com/sponsors/tomaschochola} GitHub Sponsors
 */

declare(strict_types=1);

\ob_start();
\ob_implicit_flush(false);

require_once __DIR__ . '/vendor/autoload.php';

use Src\Main;

new Main()();
