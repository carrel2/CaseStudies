<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Day;
use PHPUnit\Framework\TestCase;

class DayTest extends TestCase
{
  public function testDescription() {
    $day = new Day();

    $this->assertNull($day->getDescription());

    $this->assertInstanceOf('\AppBundle\Entity\Day', $day->setDescription('Description'));
    $this->assertEquals('Description', $day->getDescription());
  }

  public function testGetResultByTest() {
    $day = new Day();
  }

  public function testGetResultByMedication() {
    $day = new Day();
  }

  public function testGetInfoByHotspot() {
    $day = new Day();
  }

  public function testCaseStudy() {
    $day = new Day();


  }

  public function testHotspotsInfo() {
    $day = new Day();


  }

  public function testTests() {
    $day = new Day();


  }

  public function testMedications() {
    $day = new Day();


  }
}
