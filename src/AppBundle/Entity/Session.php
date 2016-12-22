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
	private $day = 0;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $case = 0;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=30)
	 */
	private $email = '';

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
	 * Set day
	 *
	 * @param integer $day
	 *
	 * @return Session
	 */
	public function setDay($day)
	{
		$this->day = $day;

		return $this;
	}

	/**
	 * Get day
	 *
	 * @return integer
	 */
	public function getDay()
	{
		return $this->day;
	}

	/**
	 * Set case
	 *
	 * @param integer $case
	 *
	 * @return Session
	 */
	public function setCase($case)
	{
		$this->case = $case;

		return $this;
	}

	/**
	 * Get case
	 *
	 * @return integer
	 */
	public function getCase()
	{
		return $this->case;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Session
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
	 * Set email
	 *
	 * @param string $email
	 *
	 * @return Session
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
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
}
