<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
  public function testDefaultAction() {
    $client = static::createClient();

    $crawler = $client->request('GET', '/', array(), array(), array('HTTP_REMOTE_USER' => 'netid'));

    system('cat var/logs/test.log');die;

    $this->assertCount(2, $crawler->filter('div.tile.box'));
    $this->assertCount(1, $crawler->filter('button#default_start'));
  }
}
