<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

/**
 * @covers \App\Document\Shorten
 */
class ShortenTest extends ApiTestCase
{
    public function testCreateShortenedUrl()
    {
        $response = static::createClient()->request('POST', '/shorten', ['json' => [
            'url' => 'https://test.example',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Shorten',
            '@type' => 'Shorten',
            'url' => 'https://test.example',
        ]);
    }
}
