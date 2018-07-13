<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
  public function testCreateCaseScenario() {
    $client = static::createClient();

    $crawler = $client->request('GET', '/admin/create/case', array(), array(), array('HTTP_REMOTE_USER' => 'netid'));

    $this->assertEquals(200, $client->getResponse()->getStatusCode());
    $this->assertCount(4, $crawler->filter('label.is-large'));

    $form = $crawler->selectButton('Create')->form(array(
      'case[title]' => 'Functional Test Case',
      'case[description]' => 'This case is only used in functional testing.',
      'case[email]' => 'functional@test.com',
    ));

    $client->submit($form);
    $crawler = $client->followRedirect();

    $id = $crawler->filter('select')->first()->children()->last()->attr('value');
    $crawler = $client->request('GET', "/admin/getCase/$id", array(), array(), array('HTTP_REMOTE_USER' => 'netid'));

    // TODO: Update

    $client->submit($crawler->selectButton('Delete')->form());
    $crawler = $client->followRedirect();

    $this->assertCount(1, $crawler->filter('div.notification.is-success'));
  }
}
