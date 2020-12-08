<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConnexionControllerTest extends WebTestCase
{
    public function testConnexion()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form();
        $form['email'] = 'nixedu06@gmail.com';
        $form['password'] = 'gtadead';
        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();

        return ['client' => $client, 'crawler' => $crawler];
    }
}