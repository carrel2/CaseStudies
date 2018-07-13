<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\TestResults;
use PHPUnit\Framework\TestCase;

class TestResultsTest extends TestCase
{
  public function testResults() {
    $tResults = new TestResults();

    $this->assertNull($tResults->getResults());

    $this->assertInstanceOf("\AppBundle\Entity\TestResults", $tResults->setResults('Results'));
    $this->assertEquals('Results', $tResults->getResults());
  }

  public function testWaitTime() {
    $tResults = new TestResults();

    $this->assertNull($tResults->getWaitTime());

    $this->assertInstanceOf("\AppBundle\Entity\TestResults", $tResults->setWaitTime('Results'));
    $this->assertEquals('Results', $tResults->getWaitTime());
  }

  public function testCost() {
    $tResults = new TestResults();

    $this->assertNull($tResults->getCost());

    $this->assertInstanceOf("\AppBundle\Entity\TestResults", $tResults->setCost(31.85));
    $this->assertEquals(31.85, $tResults->getCost());
  }

  public function testDay() {}

  public function testUserDay() {}

  public function testTest() {}
}
