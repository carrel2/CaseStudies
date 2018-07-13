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
	protected $waitTime = 0;

  /**
   * @ORM\Column(type="decimal", scale=2)
   */
  protected $dosage = 0;

  /**
   * @ORM\Column(type="integer")
   */
  protected $dosageInterval = 0;

  /**
   * @ORM\Column(type="decimal", scale=2)
   */
  protected $concentration = 1;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	protected $costPerUnit = "0";

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $defaultResult;

	public static function createFromArray($array) {
		$array = array_change_key_case($array);
		$procedure = new static();
		$properties = get_class_vars(get_class($procedure));

		foreach( array_keys($array) as $key ) {
			$prop = lcfirst(implode('', array_map('ucfirst', explode(' ', $key))));

			if( array_key_exists($prop, $properties) && $array[$key] ) {
				$procedure->$prop = $array[$key];
			} else {

			}
		}

		return $procedure;
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

  public function getPerDayCost($weight = null) {
    return $this->dosage * $this->dosageInterval / $this->concentration * $this->costPerUnit * ($weight ? $weight : 1);
  }

	public function updateFromArray($array) {
		$array = array_change_key_case($array);
		$properties = get_class_vars(get_class($this));

		foreach( array_keys($array) as $key ) {
			$prop = lcfirst(implode('', array_map('ucfirst', explode(' ', $key))));

			if( array_key_exists($prop, $properties) ) {
				$this->$prop = $array[$key];
			}
		}

		return $this;
	}
}
