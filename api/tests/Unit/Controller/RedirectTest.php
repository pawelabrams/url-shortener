<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\Redirect;
use App\Document\Shorten;
use App\Repository\ShortenRepository;
use PHPUnit\Framework\TestCase;

/**
 * Ensure that the redirection causes the visitor count to increase.
 *
 * @covers \App\Controller\Redirect
 */
class RedirectTest extends TestCase
{
    public function testFound(): void
    {
        $shorten = new Shorten();
        $shorten->url = 'anUrl';

        $repo = $this->createShortenRepository();
        $repo->expects($this->once())->method('incrementVisitors')->with('anId');
        $repo->expects($this->once())->method('find')->with('anId')->willReturn($shorten);

        $controller = new Redirect($repo);

        $response = ($controller)('anId');

        $this->assertEquals(308, $response->getStatusCode());
    }

    public function testNotFound(): void
    {
        $repo = $this->createShortenRepository();
        $repo->expects($this->never())->method('incrementVisitors')->with('anId');
        $repo->expects($this->once())->method('find')->with('anId')->willReturn(null);

        $controller = new Redirect($repo);

        $response = ($controller)('anId');

        $this->assertEquals(307, $response->getStatusCode());
    }

    /**
     * Create a shortened URL repository mock.
     */
    private function createShortenRepository(): ShortenRepository
    {
        $repo = $this->getMockBuilder(ShortenRepository::class)
                     ->disableOriginalConstructor()->getMock();

        return $repo;
    }
}
