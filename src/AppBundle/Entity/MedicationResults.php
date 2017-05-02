<?php
// src/AppBundle/Entity/MedicationResults.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Therapeutic Medication Results class
 *
 * Contains results for a specific Medication on a specific Day
 *
 * @see Medication::class
 * @see Day::class
 *
 * @ORM\Entity
 * @ORM\Table(name="MedicationResults")
 */
class MedicationResults
{
	/**
	 * Auto-generated unique id
	 *
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * Associated Day
	 *
	 * @var Day
	 *
	 * @see Day::class
	 *
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="medications")
	 */
	private $day;

	/**
	 * Associated UserDay
	 *
	 * @var UserDay
	 *
	 * @see UserDay::class
	 *
	 * @ORM\ManyToOne(targetEntity="UserDay", inversedBy="medications")
	 * @ORM\JoinColumn(name="user_day_id", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $userDay;

	/**
	 * Associated Medication
	 *
	 * @var Medication
	 *
	 * @see Medication::class
	 *
	 * @ORM\ManyToOne(targetEntity="Medication", inversedBy="results")
	 */
	private $medication;

	/**
	 * The results for the associated Medication
	 *
	 * @var string
	 *
	 * @see Medication::class
	 *
	 * @ORM\Column(type="text")
	 */
	private $results;

	public function __toString()
	{
		return sprintf("%s: %s", $this->medication->getName(), $this->results);
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
     * Set results
     *
     * @param string $results
     *
     * @return self
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
		 * @see Medication::class
     *
     * @return self
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
		 * @see Day::class
     *
     * @return self
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
		 * @see UserDay::class
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
