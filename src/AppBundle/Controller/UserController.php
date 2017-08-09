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
	 * @Route("/user", name="user")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function userAction(Request $r)
	{
		$user = $this->getUser();

		$form = $this->createForm( 'AppBundle\Form\UserType', $user );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$user = $form->getData();

			try {
				$em->flush();

				$this->addFlash('success', 'Changes saved');
			} catch( \Doctrine\ORM\ORMException $e ) {
				$this->addFlash('error', 'Something went wrong, changes were not saved!');
			}
		}

		return $this->render('Default/user.html.twig', array(
			'form' => $form->createView(),
		));
	}

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

	public function logoutAction(Request $r) {
		return;
	}
}
