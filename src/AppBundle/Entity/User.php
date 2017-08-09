<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Entity
* @ORM\Table(name="app_users")
* @UniqueEntity(fields="email", message="Email already exists")
* @UniqueEntity(fields="username", message="Username already exists")
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
	* @Assert\NotBlank()
	*/
	private $username;

	/**
	* @Assert\Length(min=6,max=4096,minMessage="Password must be at least {{ limit }} characters long")
	*/
	private $plainPassword;

	/**
	* @ORM\Column(type="string", length=64)
	*/
	private $password;

	/**
	* @ORM\Column(type="string", length=60, unique=true)
	* @Assert\NotBlank()
	* @Assert\Email()
	*/
	private $email;

	/**
	* @ORM\Column(type="string", length=9, unique=true)
	* @Assert\NotBlank()
	* @Assert\Length(min=9, max=9)
	*/
	private $uin;

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
	* @ORM\Column(name="is_active", type="boolean")
	*/
	private $isActive;

	public function __construct()
	{
		$this->days = new ArrayCollection();
		$this->results = new ArrayCollection();
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

	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	public function setPlainPassword($password)
	{
		$this->plainPassword = $password;
	}

	public function getRole() {
		return $this->role;
	}

	public function setRole($role)
	{
		$this->role = $role;

		return $this;
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
			$this->password,
			// $this->salt,
		));
	}

	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
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

	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setUin($uin)
	{
		$this->uin = $uin;

		return $this;
	}

	public function getUin()
	{
		return $this->uin;
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
