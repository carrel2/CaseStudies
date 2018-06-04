<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
  public function testUsername() {
    $user = new User();

    $this->assertNull($user->getUsername());

    $this->assertInstanceOf("\AppBundle\Entity\User", $user->setUsername('Username'));
    $this->assertEquals('Username', $user->getUsername());
  }

  public function testRole() {
    $user = new User();

    $this->assertEquals('ROLE_USER', $user->getRole());

    $this->assertInstanceOf("\AppBundle\Entity\User", $user->setRole('ROLE_NEW'));
    $this->assertEquals('ROLE_NEW', $user->getRole());
  }

  public function testLocation() {
    $user = new User();

    $this->assertNull($user->getLocation());

    $this->assertInstanceOf("\AppBundle\Entity\User", $user->setLocation('Location'));
    $this->assertEquals('Location', $user->getLocation());
  }

  public function testCurrentProgress() {
    $user = new User();

    $this->assertEmpty($user->getCurrentProgress());

    $this->assertInstanceOf("\AppBundle\Entity\User", $user->setCurrentProgress('Progress'));
    $this->assertEmpty($user->getCurrentProgress());

    $user->setIsActive(true);
    $this->assertInstanceOf("\AppBundle\Entity\User", $user->setCurrentProgress('Progress'));
    $this->assertEquals('Progress', $user->getCurrentProgress());
  }

  public function testIsActive() {
    $user = new User();

    $this->assertFalse($user->getIsActive());

    $this->assertInstanceOf("\AppBundle\Entity\User", $user->setIsActive(true));
    $this->assertTrue($user->getIsActive());
  }

  public function testCaseStudy() {}

  public function testDays() {}

  public function testResults() {}
}
