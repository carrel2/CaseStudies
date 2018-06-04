<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\MedicationResults;
use PHPUnit\Framework\TestCase;

class MedicationResultsTest extends TestCase
{
  public function testResults() {
    $mResults = new MedicationResults();

    $this->assertNull($mResults->getResults());

    $this->assertInstanceOf('\AppBundle\Entity\MedicationResults', $mResults->setResults('Results'));
    $this->assertEquals('Results', $mResults->getResults());
  }

  public function testWaitTime() {
    $mResults = new MedicationResults();

    $this->assertNull($mResults->getWaitTime());

    $this->assertInstanceOf('\AppBundle\Entity\MedicationResults', $mResults->setWaitTime('4'));
    $this->assertEquals('4', $mResults->getWaitTime());
  }

  public function testCost() {
    $mResults = new MedicationResults();

    $this->assertNull($mResults->getCost());

    $this->assertInstanceOf('\AppBundle\Entity\MedicationResults', $mResults->setCost(35.24));
    $this->assertEquals(35.24, $mResults->getCost());
  }

  public function testDay() {}

  public function testUserDay() {}

  public function testMedication() {}
}
