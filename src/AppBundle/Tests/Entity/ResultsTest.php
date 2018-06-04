<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Results;
use PHPUnit\Framework\TestCase;

class ResultsTest extends TestCase
{
  public function testResults() {
    $results = new Results();
    $rArray = array();

    $this->assertNull($results->getResults());

    $this->assertInstanceOf('\AppBundle\Entity\Results', $results->setResults($rArray));
  }

  public function testLocation() {
    $results = new Results();

    $this->assertNull($results->getLocation());

    $this->assertInstanceOf('\AppBundle\Entity\Results', $results->setLocation('Location'));
    $this->assertEquals('Location', $results->getLocation());
  }

  public function testUser() {}

  public function testCaseStudy() {}
}
