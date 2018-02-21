<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserController extends Controller
{
	/**
	 * @Route("/user/results", name="results")
	 */
	public function resultsAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$results = $em->getRepository('AppBundle:Results')->findByUser($this->getUser());

		return $this->render('Default/results.html.twig', array(
			'results' => $results,
		));
	}
}
