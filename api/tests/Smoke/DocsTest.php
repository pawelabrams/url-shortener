<?php

declare(strict_types=1);

namespace App\Tests\Smoke;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

/**
 * This test ensures /docs page is available in deployment.
 */
class DocsTest extends ApiTestCase
{
    public function testCreateShortenedUrl()
    {
        $client = static::createClient();

        /** Swagger */
        $response = $client->request('GET', '/docs');
        $this->assertResponseStatusCodeSame(200);

        /** ReDoc */
        $response = $client->request('GET', '/docs?ui=re_doc');
        $this->assertResponseStatusCodeSame(200);
    }
}
