<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\HotSpot;
use PHPUnit\Framework\TestCase;

class HotSpotTest extends TestCase
{
  public function testName() {
    $hotspot = new HotSpot();

    $this->assertNull($hotspot->getName());

    $this->assertInstanceOf('\AppBundle\Entity\HotSpot', $hotspot->setName('Heart'));
    $this->assertEquals('Heart', $hotspot->getName());
  }

  public function testCoords() {
    $hotspot = new HotSpot();
    $coords = array(1, 2, 3, 4);

    $this->assertNull($hotspot->getCoords());

    $this->assertInstanceOf('\AppBundle\Entity\HotSpot', $hotspot->setCoords($coords));
    $this->assertEquals($coords, $hotspot->getCoords());
  }

  public function testAnimal() {
    $hotspot = new HotSpot();


  }

  public function testInfo() {
    $hotspot = new HotSpot();


  }
}
