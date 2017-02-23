<?php
// src/AppBundle/Entity/MedicationResults.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MedicationResults")
 */
class MedicationResults
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="medications")
	 */
	private $day;

	/**
	 * @ORM\ManyToOne(targetEntity="UserDay", inversedBy="medications")
	 */
	private $userDay;

	/**
	 * @ORM\ManyToOne(targetEntity="Medication", inversedBy="results")
	 */
	private $medication;

	/**
	 * @ORM\Column(type="text")
	 */
	private $results;

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
     * Set results
     *
     * @param string $results
     *
     * @return MedicationResults
     */
    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Get results
     *
     * @return string
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set medication
     *
     * @param \AppBundle\Entity\Medication $medication
     *
     * @return MedicationResults
     */
    public function setMedication(\AppBundle\Entity\Medication $medication = null)
    {
        $this->medication = $medication;

        return $this;
    }

    /**
     * Get medication
     *
     * @return \AppBundle\Entity\Medication
     */
    public function getMedication()
    {
        return $this->medication;
    }

    /**
     * Set day
     *
     * @param \AppBundle\Entity\Day $day
     *
     * @return MedicationResults
     */
    public function setDay(\AppBundle\Entity\Day $day = null)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \AppBundle\Entity\Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set userDay
     *
     * @param \AppBundle\Entity\UserDay $userDay
     *
     * @return MedicationResults
     */
    public function setUserDay(\AppBundle\Entity\UserDay $userDay = null)
    {
        $this->userDay = $userDay;

        return $this;
    }

    /**
     * Get userDay
     *
     * @return \AppBundle\Entity\UserDay
     */
    public function getUserDay()
    {
        return $this->userDay;
    }
}
