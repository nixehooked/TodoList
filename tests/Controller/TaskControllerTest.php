<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TaskControllerTest extends ConnexionController
{
    public function testListAction()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/tasks');

        $this->assertSame("Liste des tâches en cours", $crawler->filter('h2')->text());
    }

    public function testListActionFinished()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/tasks');

        $link = $crawler->selectLink('Accéder à la liste des tâches terminés')->link();
        $crawler = $client->click($link);

        $this->assertSame("Liste des tâches terminées", $crawler->filter('h2')->text());
    }

    public function testCreatePage()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/tasks/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testCreateTask()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Test';
        $form['task[content]'] = 'Ceci est un article de test';
        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }


    public function testEditPage()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/tasks');

        $link = $crawler->selectLink('Test')->link();
        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testEditTask()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/tasks');

        $link = $crawler->selectLink('Test')->link();
        $crawler = $client->click($link);

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Test';
        $form['task[content]'] = 'Ceci est un article de test modifié';
        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testToggleTask()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $client->request('GET', '/tasks/5/toggle');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }


    public function testDeleteTask()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $client->request('GET', '/tasks/26/delete');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }
}