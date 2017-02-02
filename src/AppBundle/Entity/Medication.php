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
	 * @ORM\Column(type="string", length=10)
	 */
	private $cost;

	/**
	 * @ORM\OneToMany(targetEntity="MedicationResults", mappedBy="medication")
	 */
	private $results;

	public function __construct()
	{
		$this->results = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Medication
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cost
     *
     * @param string $cost
     *
     * @return Medication
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Add result
     *
     * @param \AppBundle\Entity\MedicationResults $result
     *
     * @return Medication
     */
    public function addResult(\AppBundle\Entity\MedicationResults $result)
    {
        $this->results[] = $result;

        return $this;
    }

    /**
     * Remove result
     *
     * @param \AppBundle\Entity\MedicationResults $result
     */
    public function removeResult(\AppBundle\Entity\MedicationResults $result)
    {
        $this->results->removeElement($result);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResults()
    {
        return $this->results;
    }
}
