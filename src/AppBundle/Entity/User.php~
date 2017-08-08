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
* User class
*
* Contains User information
*
* @ORM\Entity
* @ORM\Table(name="app_users")
* @UniqueEntity(fields="email", message="Email already exists")
* @UniqueEntity(fields="username", message="Username already exists")
*/
class User implements UserInterface, \Serializable
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
	* Array of roles granted to the User
	*
	* @var array
	*
	* @ORM\Column(type="string")
	*/
	private $role;

	/**
	* The username of the User
	*
	* @var string
	*
	* @ORM\Column(type="string", length=25, unique=true)
	* @Assert\NotBlank()
	*/
	private $username;

	/**
	* The plain password submitted from login and register forms
	*
	* @var string
	*
	* @Assert\Length(min=6,max=4096,minMessage="Password must be at least {{ limit }} characters long")
	*/
	private $plainPassword;

	/**
	* The encoded password for the User
	*
	* @var string
	*
	* @ORM\Column(type="string", length=64)
	*/
	private $password;

	/**
	* Email for the User
	*
	* @var string
	*
	* @ORM\Column(type="string", length=60, unique=true)
	* @Assert\NotBlank()
	* @Assert\Email()
	*/
	private $email;

	/**
	* UIN for the User
	*
	* @var string
	*
	* @ORM\Column(type="string", length=9, unique=true)
	* @Assert\NotBlank()
	* @Assert\Length(min=9, max=9)
	*/
	private $uin;

	/**
	* The location of the CaseStudy
	*
	* Either farm or hospital. Provided by the user. Used to decide the order that the Diagnostic and Therapeutic pages are shown
	*
	* @var string
	*
	* @ORM\Column(type="string", length=8, nullable=true)
	*/
	private $location;

	/**
	* Associated CaseStudy
	*
	* @var CaseStudy
	*
	* @see CaseStudy::class
	*
	* @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="users", cascade={"persist"})
	*/
	private $caseStudy;

	/**
	* ArrayCollection of UserDay objects
	*
	* @var ArrayCollection
	*
	* @see User'AppBundle\Entity\Day'
	* @see ArrayCollection::class
	*
	* @ORM\OneToMany(targetEntity="UserDay", mappedBy="user", cascade={"all"}, orphanRemoval=true)
	*/
	private $days;

	/**
	* ArrayCollection of Results objects
	*
	* @var ArrayCollection
	*
	* @see Results::class
	* @see ArrayCollection::class
	*
	* @ORM\OneToMany(targetEntity="Results", mappedBy="user", orphanRemoval=true)
	*/
	private $results;

	/**
	* Boolean isActive
	*
	* @var Boolean
	*
	* @ORM\Column(name="is_active", type="boolean")
	*/
	private $isActive;

	/**
	* Constructor function
	*
	* Initializes $days, $results as ArrayCollection, gives all User objects ROLE_USER by default
	*
	* @see ArrayCollection::class
	*/
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
		// you *may* need a real salt depending on your encoder
		// see section on salt below
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

	/**
	* Get role
	*
	* @return string
	*/
	public function getRole() {
		return $this->role;
	}

	/**
	* Set role
	*
	* @param string $role
	*
	* @return self
	*/
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

	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password,
			// see section on salt below
			// $this->salt,
		));
	}

	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
			// see section on salt below
			// $this->salt
		) = unserialize($serialized);
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
	* @return User
	*/
	public function setUsername($name)
	{
		$this->username = $name;

		return $this;
	}

	/**
	* Set password
	*
	* @param string $password
	*
	* @return User
	*/
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}

	/**
	* Set email
	*
	* @param string $email
	*
	* @return User
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

	public function setUin($uin)
	{
		$this->uin = $uin;

		return $this;
	}

	public function getUin()
	{
		return $this->uin;
	}

	/**
	* Set location
	*
	* @param string $location
	*
	* @return User
	*/
	public function setLocation($location)
	{
		$this->location = $location;

		return $this;
	}

	/**
	* Get location
	*
	* @return string
	*/
	public function getLocation()
	{
		return $this->location;
	}

	/**
	* Get active UserDay
	*
	* @see User'AppBundle\Entity\Day'
	*
	* @return \AppBundle\Entity\UserDay
	*/
	public function getCurrentDay()
	{
		return $this->days->last();
	}

	/**
	* Set isActive
	*
	* @param boolean $isActive
	*
	* @return self
	*/
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;

		return $this;
	}

	/**
	* Get isActive
	*
	* @return boolean
	*/
	public function getIsActive()
	{
		return $this->isActive;
	}

	/**
	* Set caseStudy
	*
	* @param \AppBundle\Entity\CaseStudy $caseStudy
	*
	* @see CaseStudy::class
	*
	* @return self
	*/
	public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
	{
		$this->caseStudy = $caseStudy;
		$this->isActive = !$caseStudy == null;

		return $this;
	}

	/**
	* Get caseStudy
	*
	* @see CaseStudy::class
	*
	* @return \AppBundle\Entity\CaseStudy
	*/
	public function getCaseStudy()
	{
		return $this->caseStudy;
	}

	/**
	* Add day
	*
	* @param \AppBundle\Entity\UserDay $day
	*
	* @see User'AppBundle\Entity\Day'
	*
	* @return self
	*/
	public function addDay(\AppBundle\Entity\UserDay $day)
	{
		$day->setUser($this);
		$this->days[] = $day;

		return $this;
	}

	/**
	* Remove day
	*
	* @param \AppBundle\Entity\UserDay $day
	*
	* @see User'AppBundle\Entity\Day'
	*
	* @return self
	*/
	public function removeDay(\AppBundle\Entity\UserDay $day)
	{
		$day->setUser(null);
		$this->days->removeElement($day);

		return $this;
	}

	/**
	* Remove all days
	*/
	public function removeDays()
	{
		foreach ($this->days as $day) {
			$this->removeDay($day);
		}
		$this->days->clear();
	}

	/**
	* Get days
	*
	* @return \Doctrine\Common\Collections\Collection
	*/
	public function getDays()
	{
		return $this->days;
	}

	/**
	* Add result
	*
	* @param \AppBundle\Entity\Results $result
	*
	* @return User
	*/
	public function addResult(\AppBundle\Entity\Results $result)
	{
		$result->setUser($this);
		$this->results[] = $result;

		return $this;
	}

	/**
	* Remove result
	*
	* @param \AppBundle\Entity\Results $result
	*/
	public function removeResult(\AppBundle\Entity\Results $result)
	{
		$result->setUser(null);
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

	public function hasResults()
	{
		return !$this->results->isEmpty();
	}
}
