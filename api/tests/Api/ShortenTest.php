<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Document\Shorten;

/**
 * @covers \App\Document\Shorten
 */
class ShortenTest extends ApiTestCase
{
    public function testCreateShortenedUrl()
    {
        $client = static::createClient();

        /** HTTPS is OK */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 'https://test.example',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertMatchesResourceItemJsonSchema(Shorten::class);
        $this->assertJsonContains([
            'url' => 'https://test.example',
            'visitors' => 0,
        ]);

        /** HTTP is OK */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 'http://test.example',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertMatchesResourceItemJsonSchema(Shorten::class);
        $this->assertJsonContains([
            'url' => 'http://test.example',
            'visitors' => 0,
        ]);

        /** FTP: 422 */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 'ftp://test.example',
        ]]);

        $this->assertResponseStatusCodeSame(422);

        /** Websockets: 422 */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 'wss://test.example',
        ]]);

        $this->assertResponseStatusCodeSame(422);

        /** No protocol: 422 */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 'test.example',
        ]]);

        $this->assertResponseStatusCodeSame(422);

        /** Bad field name: 422 */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'link' => 'https://test.example',
        ]]);

        $this->assertResponseStatusCodeSame(422);

        /** Null in field: 400 */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => null,
        ]]);

        $this->assertResponseStatusCodeSame(400);

        /** Number in field: 400 */
        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 1,
        ]]);

        $this->assertResponseStatusCodeSame(400);
    }

    /**
     * @depends testCreateShortenedUrl
     */
    public function testViewShortenedUrl()
    {
        $client = static::createClient();

        // Find internal resource id (eg. "/api/shorten/00001P")
        $iri = $this->findIriBy(Shorten::class, ['url' => 'https://test.example']);

        $client->request('GET', $iri);
        $this->assertResponseIsSuccessful();
    }

    public function testViewCollectionOfShortenedUrls()
    {
        $response = static::createClient()->request('GET', '/api/shorten');

        $this->assertResponseStatusCodeSame(200);
        $this->assertMatchesResourceCollectionJsonSchema(Shorten::class);
    }

    public function testDeleteShortenedUrl()
    {
        $client = static::createClient();

        $response = $client->request('POST', '/api/shorten', ['json' => [
            'url' => 'https://delete-test.example',
        ]]);

        // Find internal resource id (eg. "/api/shorten/00001P")
        $iri = $this->findIriBy(Shorten::class, ['url' => 'https://delete-test.example']);

        $response = $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);
        $this->assertEmpty($response->getContent());

        /** Wrong id: 404 */
        $response = $client->request('DELETE', '/api/shorten/0001');
        $this->assertResponseStatusCodeSame(404);

        /** Zero id: 404 */
        $response = $client->request('DELETE', '/api/shorten/0');
        $this->assertResponseStatusCodeSame(404);

        /** No id: 404 */
        $response = $client->request('DELETE', '/api/shorten/');
        $this->assertResponseStatusCodeSame(404);

        /** Collection URL used: 405 */
        $response = $client->request('DELETE', '/api/shorten');
        $this->assertResponseStatusCodeSame(405);
    }
}
