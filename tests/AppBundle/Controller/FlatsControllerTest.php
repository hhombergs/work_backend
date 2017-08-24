<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FlatsControllerTest extends WebTestCase
{

    public function testGet()
    {
        $client = static::createClient();
        $client->request('GET', '/flats');
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), TRUE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(2, $content);
    }

    public function testId()
    {
        $client = static::createClient();
        $client->request('GET', '/flats/1');
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), TRUE);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(8, $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertEquals('2017-01-02T00:00:00+01:00', $content['enter_date']);
    }

    public function testPost()
    {
        $client = static::createClient();
        $data = [];
        $client->request('POST', '/flats/');
        $this->assertEquals(406, $client->getResponse()->getStatusCode());
        $data = [
            'street' => 'Vilbeler Landstr. 203',
            'zip' => '60388',
            'city' => 'Frankfurt',
            'country' => 'Deutschland',
            'contact_email' => 'heinz.hombergs@web.de',
        ];
        $client->request('POST', '/flats/', $data);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->request('GET', '/flats');
        $content = json_decode($client->getResponse()->getContent(), TRUE);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(3, $content);
        $client->request('GET', '/flats/3');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), TRUE);
        $this->assertCount(8, $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertEquals('heinz.hombergs@web.de', $content['contact_email']);
    }
    
    public function testPut()
    {
        $client = static::createClient();
        $client->request('PUT', '/flats/-1/I9xGz6iU');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $client->request('PUT', '/flats/2/I9xGz6iUXXX');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $data = [
            'street' => 'Grüner Weg 64',
            'city' => 'Duisburg',
            'country' => 'Irland',
        ];
        $client->request('PUT', '/flats/2/I9xGz6iU', $data);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->request('GET', '/flats/2');
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), TRUE);
        $this->assertEquals('Grüner Weg 64', $content['street']);
        $this->assertEquals('Duisburg', $content['city']);
        $this->assertEquals('Irland', $content['country']);
    }

    public function testDelete()
    {
        $client = static::createClient();
        $client->request('DELETE', '/flats/-1/I9xGz6iU');
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
