<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends ConnexionController
{

    public function testListAction()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $link = $crawler->selectLink('Utilisateurs')->link();
        $crawler = $client->click($link);

        $this->assertSame("Liste des utilisateurs", $crawler->filter('h1')->text());
    }

    public function testCreatePage()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $client->click($link);

        $this->assertSame("Créer un utilisateur", $crawler->filter('h1')->text());
    }

    public function testCreateUser()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'demo';
        $form['user[password][first]'] = 'demo';
        $form['user[password][second]'] = 'demo';
        $form['user[email]'] = 'demo@demo.fr';
        $crawler = $client->submit($form);

        //$crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());

        $crawler = $client->request('GET', '/users');

        $id = $crawler->filter("#user-demo p")->text();

        $crawler = $client->request('DELETE', '/users/' . $id . '/delete');

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testEditUser()
    {
        $array = $this->connexion();
        $client = $array['client'];
        $crawler = $array['crawler'];

        $crawler = $client->request('GET', '/users/4/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSame('Nom d\'utilisateur', $crawler->filter('label[for="user_username"]')->text());
        $this->assertSame('Mot de passe', $crawler->filter('label[for="user_password_first"]')->text());
        $this->assertSame('Adresse email', $crawler->filter('label[for="user_email"]')->text());

        $this->assertEquals(1, $crawler->filter('input[name="user[username]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[password][first]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[password][second]"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="user[email]"]')->count());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'NixeTest';
        $form['user[password][first]'] = 'root';
        $form['user[password][second]'] = 'root';
        $form['user[email]'] = 'nixetest@example.org';
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }

}