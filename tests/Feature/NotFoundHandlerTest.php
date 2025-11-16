<?php

declare(strict_types=1);

namespace Tests\Feature;

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;
use Random\Randomizer;
use Tests\TestCase;

/**
 * @internal
 */
#[Small]
#[CoversNothing]
final class NotFoundHandlerTest extends TestCase
{
    #[Test]
    public function test(): void
    {
        $response = $this->handle($this->createServerRequest(RequestMethodInterface::METHOD_GET, (new Randomizer())->getBytesFromString(\implode('', \range(\chr(33), \chr(126))), 64)));

        self::assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }
}
