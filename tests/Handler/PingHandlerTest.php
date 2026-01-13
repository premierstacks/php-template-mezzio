<?php

declare(strict_types=1);

namespace Tests\Handler;

use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;
use Src\Handler\PingHandler;
use Tests\TestCase;

/**
 * @internal
 */
#[CoversClass(PingHandler::class)]
#[Small]
final class PingHandlerTest extends TestCase
{
    #[Test]
    public function test(): void
    {
        $response = $this->handle($this->createServerRequest(PingHandler::METHOD, PingHandler::PATH));

        self::assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
