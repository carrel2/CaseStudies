<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TherapeuticsController extends Controller
{
	/**
	 * @Route("/therapeutics", name="therapeutics")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPageAction(Request $r)
	{
		$user = $this->getUser();
		$currentDay = $user->getCurrentDay();

		if( !$user->getIsActive() || $user->getCurrentProgress() != 'therapeutics' ) {
			return $this->redirectToRoute('default');
		}

		$weight = $user->getEstimatedWeight();

		$form = $this->createForm( 'AppBundle\Form\TherapeuticsType' );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$medications = $form->getData()['therapeuticProcedure'];

			$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

			$tCost = 0;

			foreach( $medications as $medication )
			{
				$results = $day->getResultByTherapeuticProcedure($medication);
				if( $results ) {
					$currentDay->addTherapeutic($results);
				} else {
					$currentDay->addEmptyTherapeuticResults($medication);
				}
			}

			$user->setCurrentProgress('review');

			$em->flush();

			return $this->redirectToRoute('logic');
		}

		return $this->render('Default/therapeutics.html.twig', array(
			'form' => $form->createView(),
			'animal_weight' => $weight,
		));
	}
}
