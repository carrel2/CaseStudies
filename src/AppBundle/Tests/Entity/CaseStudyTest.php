<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\CaseStudy;
use PHPUnit\Framework\TestCase;

class CaseStudyTest extends TestCase
{
  public function testTitle() {
    $caseStudy = new CaseStudy();

    $this->assertNull($caseStudy->getTitle());

    $this->assertInstanceOf('\AppBundle\Entity\CaseStudy', $caseStudy->setTitle('Title'));
    $this->assertEquals('Title', $caseStudy->getTitle());
  }

  public function testDescription() {
    $caseStudy = new CaseStudy();

    $this->assertNull($caseStudy->getDescription());

    $this->assertInstanceOf('\AppBundle\Entity\CaseStudy', $caseStudy->setDescription('Description'));
    $this->assertEquals('Description', $caseStudy->getDescription());
  }

  public function testEmail() {
    $caseStudy = new CaseStudy();

    $this->assertNull($caseStudy->getEmail());

    $this->assertInstanceOf('\AppBundle\Entity\CaseStudy', $caseStudy->setEmail('email@example.com'));
    $this->assertEquals('email@example.com', $caseStudy->getEmail());
  }

  public function testAnimal() {
    $caseStudy = new CaseStudy();
  }

  public function testDays() {
    $caseStudy = new CaseStudy();
  }

  public function testUsers() {
    $caseStudy = new CaseStudy();
  }
}
