<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConnexionController extends WebTestCase
{
    protected function connexion()
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