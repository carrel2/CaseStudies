<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\HotSpotInfo;
use PHPUnit\Framework\TestCase;

class HotSpotInfoTest extends TestCase
{
  public function testInfo() {
    $hsInfo = new HotSpotInfo();

    $this->assertNull($hsInfo->getInfo());

    $this->assertInstanceOf('\AppBundle\Entity\HotSpotInfo', $hsInfo->setInfo('Info'));
    $this->assertEquals('Info', $hsInfo->getInfo());
  }
}
