<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Task;


class TaskControllerTest extends WebTestCase
{
    private $client;
    private int $taskId;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->initTask();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Me connecter')->form();
        $this->client->submit($form, ['email' => 'admin@admin.fr', 'password' => 'password']);
    }

    public function loginUser2(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Me connecter')->form();
        $this->client->submit($form, ['email' => 'user2@gnut.eu', 'password' => 'password']);
    }

    public function testList()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testListEnding()
    {
        $this->loginUser();
        $this->client->request('GET', '/tasks/ending');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testCreate()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Titre de la tâche test';
        $form['task[content]'] = 'Contenu de la tâche test';
        $this->client->submit($form);


        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


    public function testCreateNotConnectedUser()
    {
        $crawler = $this->client->request('GET', '/tasks/create');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
    }

    public function testEdit()
    {
        $this->loginUser();

        $crawler = $this->client->request('GET', '/tasks/'.$this->taskId.'/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Titre de la tâche edited';
        $form['task[content]'] = 'Contenu de la tâche edited';
        $this->client->submit($form);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testToggle()
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks/'.$this->taskId.'/toggle');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
    
    public function testDeleteAccessDeniedException()
    {
        $this->client->request('GET', '/tasks/'.$this->taskId.'/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
    }

    public function testDeleteAccessDeniedExceptionNotAuthor()
    {
        $this->loginUser2();
        $this->client->request('GET', '/tasks/10/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
    }

    // public function testDeleteAccessDeniedExceptionNotTask()
    // {
    //     $this->loginUser2();
    //     $this->client->request('GET', '/tasks/1/delete');

    //     $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

    //     $crawler = $this->client->followRedirect();

    //     $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    //     $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
    // }

    public function testDelete()
    {
        $this->loginUser();

        $this->client->request('GET', '/tasks/'.$this->taskId.'/delete');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    /**
     * @return void
     */
    public function initTask(): void
    {

        $container = $this->client->getContainer();
        $manager = $container->get('doctrine')->getManager();
        $taskRepository = $manager->getRepository(Task::class);
        $task = $taskRepository->getLastTask();
        
        $this->taskId = $task->getId();
    }

}