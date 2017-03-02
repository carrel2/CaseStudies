<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User class
 *
 * Contains user information
 *
 * @ORM\Entity
 * @ORM\Table(name="app_users")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
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
	 * @ORM\Column(type="array")
	 */
	private $roles;

	/**
	 * @ORM\Column(type="string", length=25, unique=true)
	 * @Assert\NotBlank()
	 */
	private $username;

	/**
	 * @Assert\Length(max=4096)
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
	 * @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="users", cascade={"persist"})
	 */
	private $caseStudy;

	/**
	 * @ORM\OneToMany(targetEntity="UserDay", mappedBy="user", cascade={"all"}, orphanRemoval=true)
	 */
	private $days;

	/**
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;

	public function __construct()
	{
		$this->days = new ArrayCollection();
		$this->isActive = true;
		$this->roles[] = 'ROLE_USER';
		// may not be needed, see section on salt below
		// $this->salt = md5(uniqid(null, true));
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

	public function getRoles()
	{
		return $this->roles;
	}

	public function addRole($role)
	{
		$this->roles[] = $role;

		return $this;
	}

	public function removeRole($role)
	{
		$i = array_search($role, $this->roles);
		unset($this->roles[$i]);
		$this->roles = array_values($this->roles);

		return $this;
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
	 * Get active day
	 *
	 * @return \AppBundle\Entity\Day $day
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
	 * @return User
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
	 * @return User
	 */
	public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
	{
		$this->caseStudy = $caseStudy;

		return $this;
	}

	/**
	 * Get caseStudy
	 *
	 * @return \AppBundle\Entity\CaseStudy
	 */
	public function getCaseStudy()
	{
		return $this->caseStudy;
	}

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Add day
     *
     * @param \AppBundle\Entity\UserDay $day
     *
     * @return User
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
     * @return User
     */
    public function removeDay(\AppBundle\Entity\UserDay $day)
    {
        $day->setUser(null);
        $this->days->removeElement($day);

        return $this;
    }

    /**
     * Remove all days
     *
     * @return User
     */
    public function removeDays()
    {
        foreach( $this->days as $day ) {
            $day->removeHotspots();
            $day->removeTests();
            $day->removeMedications();
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
}
