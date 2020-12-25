<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
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

        //$this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('h1')->count());
    }

    public function testLogout()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/logout');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}