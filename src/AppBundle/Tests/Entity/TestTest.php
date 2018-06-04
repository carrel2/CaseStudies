<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Test;
use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{
  public function testName() {
    $test = new Test();

    $this->assertNull($test->getName());

    $this->assertInstanceOf("\AppBundle\Entity\Test", $test->setName('Name'));
    $this->assertEquals('Name', $test->getName());
  }

  public function testDGroup() {
    $test = new Test();

    $this->assertNull($test->getDGroup());

    $this->assertInstanceOf("\AppBundle\Entity\Test", $test->setDGroup('Group'));
    $this->assertEquals('Group', $test->getDGroup());
  }

  public function testWaitTime() {
    $test = new Test();

    $this->assertNull($test->getWaitTime());

    $this->assertInstanceOf("\AppBundle\Entity\Test", $test->setWaitTime('4'));
    $this->assertEquals('4', $test->getWaitTime());
  }

  public function testCostPerUnit() {
    $test = new Test();

    $this->assertNull($test->getCostPerUnit());

    $this->assertInstanceOf("\AppBundle\Entity\Test", $test->setCostPerUnit('4.65'));
    $this->assertEquals('4.65', $test->getCostPerUnit());
  }

  public function testDefaultResult() {
    $test = new Test();

    $this->assertNull($test->getDefaultResult());

    $this->assertInstanceOf("\AppBundle\Entity\Test", $test->setDefaultResult('Default result'));
    $this->assertEquals('Default result', $test->getDefaultResult());
  }

  public function testResults() {}
}
