<?php
// src/AppBundle/Entity/Test.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Tests")
 */
class Test
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="text")
	 */
	private $name;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $dGroup;

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
	 * @ORM\OneToMany(targetEntity="TestResults", mappedBy="test")
	 */
	private $results;

	public function __construct(array $array = null)
	{
		$this->results = new ArrayCollection();
		if( $array )
		{
			$this->name = $array["name"];
			$this->costPerUnit = $array["cost"] === null ? 0 : $array["cost"];
			$this->dGroup = $array["group"] === null ? '' : $array["group"];
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
			$this->dGroup = $group;

			return $this;
		}

		public function getGroup()
		{
			return $this->dGroup;
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

    public function addResult(\AppBundle\Entity\TestResults $result)
    {
        $this->results[] = $result;

        return $this;
    }

    public function removeResult(\AppBundle\Entity\TestResults $result)
    {
        $this->results->removeElement($result);

				return $this;
    }

    public function getResults()
    {
        return $this->results;
    }

		public function getResultsByCase(\AppBundle\Entity\CaseStudy $caseStudy)
		{
			$collection = $this->results->filter(function($r) use ($caseStudy) {
				return $r->getDay()->getCaseStudy()->getId() == $caseStudy->getId();
			});

			return $collection->isEmpty() ? null : $collection->first();
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

    public function setDGroup($dGroup)
    {
        $this->dGroup = $dGroup;

        return $this;
    }

    public function getDGroup()
    {
        return $this->dGroup;
    }

    public function getDefaultResult() {
        return $this->defaultResult;
    }

    public function setDefaultResult($defaultResult) {
        $this->defaultResult = $defaultResult;

        return $this;
    }
}
