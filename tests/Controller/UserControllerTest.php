<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;


class UserControllerTest extends WebTestCase
{
    private $client;
    private int $userId;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->getUser();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Me connecter')->form();
        $this->client->submit($form, ['email' => 'admin@admin.fr', 'password' => 'password']);
    }

    public function testList(): void
    {
        $this->loginUser();
        $this->client->request('GET', '/users');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEdit()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/users/'.$this->userId.'/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['edit_user_form[username]'] = 'usertest1';
        // $form['edit_user_form[plainPassword]'] = 'password';
        $form['edit_user_form[email]'] = 'usertest1@gnut.eu';
        $form['edit_user_form[roles][0]']->tick();
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return void
     */
    public function getUser(): void
    {

        $container = $this->client->getContainer();
        $manager = $container->get('doctrine')->getManager();
        $userRepository = $manager->getRepository(User::class);
        $user = $userRepository->getLastUser();

        $this->userId = $user->getId();
        // $this->userId = 21;
    }

}