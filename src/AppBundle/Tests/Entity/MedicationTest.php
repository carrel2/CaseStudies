<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Medication;
use PHPUnit\Framework\TestCase;

class MedicationTest extends TestCase
{
  public function testName() {
    $medication = new Medication();

    $this->assertNull($medication->getName());

    $this->assertInstanceOf('\AppBundle\Entity\Medication', $medication->setName('Medication'));
    $this->assertEquals('Medication', $medication->getName());
  }

  public function testTGroup() {
    $medication = new Medication();

    $this->assertNull($medication->getTGroup());

    $this->assertInstanceOf('\AppBundle\Entity\Medication', $medication->setTGroup('Group'));
    $this->assertEquals('Group', $medication->getTGroup());
  }

  public function testWaitTime() {
    $medication = new Medication();

    $this->assertNull($medication->getWaitTime());

    $this->assertInstanceOf('\AppBundle\Entity\Medication', $medication->setWaitTime(1));
    $this->assertEquals(1, $medication->getWaitTime());
  }

  public function testCostPerUnit() {
    $medication = new Medication();

    $this->assertNull($medication->getCostPerUnit());

    $this->assertInstanceOf('\AppBundle\Entity\Medication', $medication->setCostPerUnit(1.50));
    $this->assertEquals(1.50, $medication->getCostPerUnit());
  }

  public function testDefaultResult() {
    $medication = new Medication();

    $this->assertNull($medication->getDefaultResult());

    $this->assertInstanceOf('\AppBundle\Entity\Medication', $medication->setDefaultResult('Default result'));
    $this->assertEquals('Default result', $medication->getDefaultResult());
  }

  public function testResults() {}

  public function testGetResultsByCase() {}

  public function testConstructor() {
    $medArray = array(
        "name" => "Medication",
        "cost" => 4.65,
        "group" => "Group",
        "wait time" => 1,
        "default result" => "Default result",
    );

    $medication = new Medication($medArray);

    $this->assertContains($medication->getName(), $medArray);
    $this->assertContains($medication->getCostPerUnit(), $medArray);
    $this->assertContains($medication->getTGroup(), $medArray);
    $this->assertContains($medication->getWaitTime(), $medArray);
    $this->assertContains($medication->getDefaultResult(), $medArray);
  }
}
