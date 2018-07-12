<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Animal;
use PHPUnit\Framework\TestCase;

class AnimalTest extends TestCase
{
  public function testName() {
    $animal = new Animal();

    $this->assertNull($animal->getName());

    $this->assertInstanceOf('\AppBundle\Entity\Animal', $animal->setName("Horse"));
    $this->assertEquals("Horse", $animal->getName());
  }

  public function testImage() {
    $animal = new Animal();

    $this->assertNull($animal->getImage());

    $this->assertInstanceOf('\AppBundle\Entity\Animal', $animal->setImage('path/to/image.jpeg'));
    $this->assertEquals('path/to/image.jpeg', $animal->getImage());
  }

  public function testCases() {
    $caseStudy = new \AppBundle\Entity\CaseStudy();
    $animal = new Animal();
  }

  public function testHotspots() {
    $caseStudy = new \AppBundle\Entity\CaseStudy();
    $animal = new Animal();
  }
}
