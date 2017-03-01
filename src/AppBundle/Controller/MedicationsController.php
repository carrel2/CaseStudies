<?php
// src/AppBundle/Controller/MedicationsController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\MedicationsType;

class MedicationsController extends Controller
{
	/**
	 * @Route("/medications", name="order_meds")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r)
	{
		$user = $this->getUser();
		$form = $this->createForm( MedicationsType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$medications = $form->getData()['medication'];

			$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

			foreach( $medications as $medication )
			{
				$user->getCurrentDay()->addMedication($day->getResultByMedication($medication));
			}

			$em->flush();

//			return $this->redirectToRoute('dayController');
			return $this->redirectToRoute('default');
		}

		return $this->render('medications.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
