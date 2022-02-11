<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SecurityControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Me connecter')->form();
        $this->client->submit($form, ['email' => 'admin@admin.fr', 'password' => 'password']);
    }

    public function testLogout()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/logout');
        // $crawler->selectLink('Se déconnecter')->link();
        $this->throwException(new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall.'));
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    }
}