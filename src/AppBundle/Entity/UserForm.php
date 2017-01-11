<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User
{
	/**
	 * @Assert\NotBlank()
	 */
	protected $name;

	/**
	 * @Assert\NotBlank()
	 */
	protected $email;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Regex("/^[0-9]{9}$/")
	 */
	protected $uin;

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

    /**
     * Set uin
     *
     * @param string $uin
     *
     * @return User
     */
    public function setUin($uin)
    {
        $this->uin = $uin;

        return $this;
    }

    /**
     * Get uin
     *
     * @return string
     */
    public function getUin()
    {
        return $this->uin;
    }
}
