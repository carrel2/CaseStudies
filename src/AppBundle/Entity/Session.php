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
	 * @ORM\Column(type="integer")
	 */
	private $dayId = 0;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $caseId = 0;

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
     * Set dayId
     *
     * @param integer $dayId
     *
     * @return Session
     */
    public function setDayId($dayId)
    {
        $this->dayId = $dayId;

        return $this;
    }

    /**
     * Get dayId
     *
     * @return integer
     */
    public function getDayId()
    {
        return $this->dayId;
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
