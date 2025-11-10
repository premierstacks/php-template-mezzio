<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Handler\PingHandler;
use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @internal
 */
#[Small]
#[CoversClass(PingHandler::class)]
class PingHandlerTest extends TestCase
{
    #[Test]
    public function testHandle(): void
    {
        $response = $this->handle($this->request('GET', '/api/v1/ping'));

        static::assertSame($response->getStatusCode(), StatusCodeInterface::STATUS_OK);
    }
}
