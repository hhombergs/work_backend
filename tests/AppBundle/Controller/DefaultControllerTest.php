<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $response = $client->getResponse();
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertContains('Access forbidden', $response->getContent());
    }
}
