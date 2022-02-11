<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
       $this->client = static::createClient();
    }

    public function testIndex()
    {
       $this->client->request('GET', '/');

       $this->assertEquals(
            200,
            $this->client->getResponse()->getStatusCode()
        );
    }

}