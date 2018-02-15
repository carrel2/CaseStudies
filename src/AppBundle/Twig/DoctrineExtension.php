<?php

namespace AppBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineExtension extends \Twig_Extension
{
	private $doctrine;

	public function __construct(RegistryInterface $doctrine)
	{
		$this->doctrine = $doctrine;
	}

	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction('find', array($this, 'find')),
		);
	}

	public function find($id, $repo)
	{
		return $this->doctrine->getManager()->getRepository($repo)->find($id);
	}
}
