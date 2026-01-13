<?php

/**
 * @copyright © 2025 Tomáš Chochola <tomaschochola@seznam.cz>
 * @license CC-BY-ND-4.0
 *
 * @see {@link https://creativecommons.org/licenses/by-nd/4.0/} License
 * @see {@link https://github.com/tomaschochola} GitHub Profile
 * @see {@link https://github.com/sponsors/tomaschochola} GitHub Sponsors
 */

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;

/**
 * @internal
 *
 * @no-named-arguments
 */
#[CoversNothing]
#[Small]
final class StubTest extends TestCase
{
    #[DoesNotPerformAssertions]
    #[Test]
    public function test(): void
    {
        $this->migrate();
    }
}
