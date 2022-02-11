<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class RegistrationControllerTest extends WebTestCase
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

    public function testRegister()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/register');
        // print($this->client->getResponse()->getContent());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $uniqId = uniqid();
        $form = $crawler->selectButton('Ajouter')->form();
        $form['registration_form[username]'] = 'NouveauTest'.$uniqId;
        $form['registration_form[plainPassword][first]'] = 'password';
        $form['registration_form[plainPassword][second]'] = 'password';
        $form['registration_form[email]'] = 'test'.$uniqId.'@gnut.eu';
        $form['registration_form[roles][0]']->tick();
        $form['registration_form[roles][1]']->tick();
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}