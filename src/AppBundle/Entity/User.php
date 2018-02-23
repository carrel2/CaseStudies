<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Entity
* @ORM\Table(name="app_users")
*/
class User implements UserInterface, \Serializable
{
	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	* @ORM\Column(type="string")
	*/
	private $role;

	/**
	* @ORM\Column(type="string", length=25, unique=true)
	*/
	private $username;

	/**
	* @ORM\Column(type="string", length=8, nullable=true)
	*/
	private $location;

	/**
	* @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="users", cascade={"persist"})
	*/
	private $caseStudy;

	/**
	* @ORM\OneToMany(targetEntity="UserDay", mappedBy="user", cascade={"all"}, orphanRemoval=true)
	*/
	private $days;

	/**
	* @ORM\OneToMany(targetEntity="Results", mappedBy="user", orphanRemoval=true)
	*/
	private $results;

	/**
	 * @ORM\Column(type="string", length=12)
	 */
  private $currentProgress;

	/**
	* @ORM\Column(name="is_active", type="boolean")
	*/
	private $isActive;

	public function __construct()
	{
		$this->days = new ArrayCollection();
		$this->results = new ArrayCollection();
		$this->currentProgress = "";
		$this->isActive = false;
		$this->role = 'ROLE_USER';
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getSalt()
	{
		return null;
	}

	public function getPassword() {}

	public function setRole($role)
	{
		$this->role = $role;

		return $this;
	}

	public function getRole() {
		return $this->role;
	}

	public function getRoles()
	{
		return array($this->role);
	}

	public function eraseCredentials()
	{
	}

	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			//$this->password,
			// $this->salt,
		));
	}

	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			//$this->password,
			// $this->salt
		) = unserialize($serialized);
	}

	public function getId()
	{
		return $this->id;
	}

	public function setUsername($name)
	{
		$this->username = $name;

		return $this;
	}

	public function setLocation($location)
	{
		$this->location = $location;

		return $this;
	}

	public function getLocation()
	{
		return $this->location;
	}

	public function getCurrentDay()
	{
		return $this->days->last();
	}

	public function setCurrentProgress($progress = "")
	{
		$this->currentProgress = $this->isActive ? $progress : "";

		return $this;
	}

	public function getCurrentProgress()
	{
		return $this->currentProgress;
	}

	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;

		return $this;
	}

	public function getIsActive()
	{
		return $this->isActive;
	}

	public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
	{
		$this->caseStudy = $caseStudy;
		$this->isActive = !$caseStudy == null;

		return $this;
	}

	public function getCaseStudy()
	{
		return $this->caseStudy;
	}

	public function addDay(\AppBundle\Entity\UserDay $day)
	{
		$day->setUser($this);
		$this->days[] = $day;

		return $this;
	}

	public function removeDay(\AppBundle\Entity\UserDay $day)
	{
		$day->setUser(null);
		$this->days->removeElement($day);

		return $this;
	}

	public function removeDays()
	{
		foreach ($this->days as $day) {
			$this->removeDay($day);
		}
		$this->days->clear();
	}

	public function getDays()
	{
		return $this->days;
	}

	public function addResult(\AppBundle\Entity\Results $result)
	{
		$result->setUser($this);
		$this->results[] = $result;

		return $this;
	}

	public function removeResult(\AppBundle\Entity\Results $result)
	{
		$result->setUser(null);
		$this->results->removeElement($result);
	}

	public function getResults()
	{
		return $this->results;
	}

	public function hasResults()
	{
		return !$this->results->isEmpty();
	}
}
