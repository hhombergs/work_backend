<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FlatsControllerTest extends WebTestCase
{
    public function testGet() {
        $client = static::createClient();
        $client->request('GET', '/flats');
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), TRUE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(2, $content);
    }
    
    public function testId() {
        $client = static::createClient();
        $client->request('GET', '/flats/1');
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), TRUE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(8, $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertEquals('2017-01-02T00:00:00+01:00', $content['enter_date']);
    }
    
    public function testDelete() {
        $client = static::createClient();
        $client->request('DELETE', '/flats/3/I9xGz6iU');
        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
        $client->request('DELETE', '/flats/2/I9xGz6iUXXX');
        $response = $client->getResponse();
        $this->assertEquals(403, $response->getStatusCode());
        $client->request('DELETE', '/flats/2/I9xGz6iU');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('"Deleted successfully"', $response->getContent());
    }
}
