<?php
// src/AppBundle/Entity/Medication.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Medications")
 */
class Medication
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=40, nullable=true)
	 */
	private $tGroup;

	/**
	 * @ORM\Column(type="string", length=4)
	 */
	private $waitTime;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	private $costPerUnit;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $defaultResult;

	/**
	 * @ORM\OneToMany(targetEntity="MedicationResults", mappedBy="medication")
	 */
	private $results;

	public function __construct(array $array = null)
	{
		$this->results = new ArrayCollection();
		if( $array )
		{
			$this->name = $array["name"];
			$this->costPerUnit = $array["cost"] === null ? 0 : $array["cost"];
			$this->tGroup = $array["group"] === null ? '' : $array["group"];
			$this->waitTime = $array["wait time"] === null ? 0 : $array["wait time"];
			$this->defaultResult = $array["default result"] === null ? '' : $array["default result"];
		}
	}

    public function getId()
    {
        return $this->id;
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

		public function setGroup($group)
		{
			$this->tGroup = $group;

			return $this;
		}

		public function getGroup()
		{
			return $this->tGroup;
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

    public function addResult(\AppBundle\Entity\MedicationResults $result)
    {
        $this->results[] = $result;

        return $this;
    }

    public function removeResult(\AppBundle\Entity\MedicationResults $result)
    {
        $this->results->removeElement($result);

				return $this;
    }

    public function getResults()
    {
        return $this->results;
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

    public function setTGroup($tGroup)
    {
        $this->tGroup = $tGroup;

        return $this;
    }

    public function getTGroup()
    {
        return $this->tGroup;
    }

    public function getDefaultResult() {
        return $this->defaultResult;
    }

    public function setDefaultResult($defaultResult) {
        $this->defaultResult = $defaultResult;

        return $this;
    }
}
