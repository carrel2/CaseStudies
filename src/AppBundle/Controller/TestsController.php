<?php
// src/AppBundle/Controller/TestsController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Test;
use AppBundle\Form\TestsType;

class TestsController extends Controller
{
	/**
	 * @Route("/tests", name="order_tests")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r)
	{
		$user = $this->getUser();
		$form = $this->createForm( TestsType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$tests = $form->getData()['test'];

			$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

			foreach( $tests as $test )
			{
				$user->getCurrentDay()->addTest($day->getResultByTest($test));
			}

			$em->flush();

			return $this->redirectToRoute('order_meds');
		}

		return $this->render('tests.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
