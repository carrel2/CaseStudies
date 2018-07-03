<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractProcedure
{
  /**
	 * @ORM\Column(type="text")
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=40, nullable=true)
	 */
	protected $groupName;

	/**
	 * @ORM\Column(type="string", length=4)
	 */
	protected $waitTime;

  /**
   * @ORM\Column(type="decimal", scale=2)
   */
  protected $dosage;

  /**
   * @ORM\Column(type="integer")
   */
  protected $dosageInterval;

  /**
   * @ORM\Column(type="decimal", scale=2)
   */
  protected $concentration;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	protected $costPerUnit;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $defaultResult;

  public function __construct(array $array = null)
  {
    if( $array )
    {
      $this->name = $array["name"];
      $this->costPerUnit = $array["cost"] === null ? 0 : $array["cost"];
      $this->groupName = $array["group"] === null ? '' : $array["group"];
      $this->waitTime = $array["wait time"] === null ? 0 : $array["wait time"];
      $this->defaultResult = $array["default result"] === null ? '' : $array["default result"];
    }
  }

  public function setName($name)
  {
      $this->name = $name;

      return $this;
  }

  public function getName()
  {
      return $this->name;
  }

  public function setGroupName($group)
  {
    $this->groupName = $group;

    return $this;
  }

  public function getGroupName()
  {
    return $this->groupName;
  }

  public function setCostPerUnit($costPerUnit)
  {
    $this->costPerUnit = $costPerUnit;

    return $this;
  }

  public function getCostPerUnit()
  {
    return $this->costPerUnit;
  }

  public function setWaitTime($waitTime)
  {
    $this->waitTime = $waitTime;

    return $this;
  }

  public function getWaitTime()
  {
    return $this->waitTime;
  }

  public function getDefaultResult() {
    return $this->defaultResult;
  }

  public function setDefaultResult($defaultResult) {
    $this->defaultResult = $defaultResult;

    return $this;
  }

  public function setDosage($dosage) {
    $this->dosage = $dosage;

    return $this;
  }

  public function getDosage() {
    return $this->dosage;
  }

  public function setDosageInterval($dosageInterval) {
    $this->dosageInterval = $dosageInterval;

    return $this;
  }

  public function getDosageInterval() {
    return $this->dosageInterval;
  }

  public function setConcentration($concentration) {
    $this->concentration = $concentration;

    return $this;
  }

  public function getConcentration() {
    return $this->concentration;
  }

  public function getPerDayCost() {
    return $this->dosage * $this->dosageInterval / $this->concentration * $this->costPerUnit;
  }
}
