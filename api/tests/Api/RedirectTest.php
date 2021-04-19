<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Document\Shorten;

/**
 * @covers \App\Controller\Redirect
 */
class RedirectTest extends ApiTestCase
{
    public function testRedirection(): void
    {
        $client = static::createClient();

        /* Permanent redirect when accessing URL: HTTP 308 */
        $this->createShortenedUrl($client);

        // Find internal resource id (eg. "/api/shorten/00001P")
        $iri = $this->findIriBy(Shorten::class, ['url' => 'https://redirect-test.example']);
        $shortenId = str_replace('/api/shorten/', '', $iri);
        $this->assertNotEmpty($shortenId);

        $response = $client->request('GET', sprintf('/%s', $shortenId));
        $this->assertResponseStatusCodeSame(308);
        $this->assertResponseHeaderSame('location', 'https://redirect-test.example');

        $response = $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'url' => 'https://redirect-test.example',
            'visitors' => 1,
        ]);

        /** Non-existent id: Redirect temporarily to a 404 page in PWA, HTTP 307 */
        $response = $client->request('GET', '/000000');
        $this->assertResponseStatusCodeSame(307);
        $this->assertResponseHeaderSame('location', '/404');
    }

    /**
     * Create a shortened URL not to depend on ShortenTest.
     */
    private function createShortenedUrl($client): void
    {
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 'https://redirect-test.example',
        ]]);

        $this->assertResponseStatusCodeSame(201);
    }
}
