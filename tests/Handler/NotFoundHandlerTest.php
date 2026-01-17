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

namespace Tests\Handler;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @internal
 */
#[CoversNothing]
#[Small]
final class NotFoundHandlerTest extends TestCase
{
    #[Test]
    public function test(): void
    {
        $response = $this->handle($this->createServerRequest('GET', '/not-found'));

        self::assertSame(404, $response->getStatusCode());
    }
}
