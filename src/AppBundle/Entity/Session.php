<?php
// src/AppBundle/Entity/Session.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Sessions")
 */
class Session
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="array")
	 */
	private $days = array();

	/**
	 * @ORM\Column(type="integer")
	 */
	private $caseId;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $userId;

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
     * Get days
     *
     * @return array
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set days
     *
     * @return Session
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Add day
     *
     * @return Session
     */
    public function addDay($day)
    {
        array_push( $this->days, $day );

        return $this;
    }

    /**
     * Get current day
     *
     * @return integer
     */
    public function getDay()
    {
        return end($this->days);
    }

    /**
     * Set caseId
     *
     * @param integer $caseId
     *
     * @return Session
     */
    public function setCaseId($caseId)
    {
        $this->caseId = $caseId;

        return $this;
    }

    /**
     * Get caseId
     *
     * @return integer
     */
    public function getCaseId()
    {
        return $this->caseId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Session
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
