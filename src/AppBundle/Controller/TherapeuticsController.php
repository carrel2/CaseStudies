<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\TherapeuticsType;

class TherapeuticsController extends Controller
{
	/**
	 * @Route("/therapeutics", name="therapeutics")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPageAction(Request $r)
	{
		$user = $this->getUser();
		$session = $r->getSession();

		if( !$user->getIsActive() || $session->get('page') != 'therapeutics' ) {
			return $this->redirectToRoute('default');
		}

		$form = $this->createForm( 'AppBundle\Form\TherapeuticsType' );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$medications = $form->getData()['medication'];

			$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

			foreach( $medications as $medication )
			{
				$results = $day->getResultByMedication($medication);
				if( $results ) {
					$user->getCurrentDay()->addMedication($results);
				} else {
					$this->addFlash('empty-therapeutic-results-' . $user->getCurrentDay()->getId(), $medication->getId());
				}
			}

			$em->flush();

			$session->set('page', 'review');

			return $this->redirectToRoute('logic');
		}

		return $this->render('Default/therapeutics.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
