<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Test;
use AppBundle\Form\DiagnosticsType;

class DiagnosticsController extends Controller
{
	/**
	 * @Route("/diagnostics", name="diagnostics")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		if( !$user->getIsActive() || !in_array($user->getCurrentProgress(), ['evaluation', 'diagnostics']) ) {
			return $this->redirectToRoute('default');
		}

		$user->setCurrentProgress('diagnostics');

		$form = $this->createForm( 'AppBundle\Form\DiagnosticsType', null, array('cs' => $user->getCaseStudy()) );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$tests = $form->getData()['test'];

			$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

			$dCost = 0;

			foreach( $tests as $test )
			{
				$results = $day->getResultByTest($test);
				if( $results )
				{
					$user->getCurrentDay()->addTest($results);
				} else {
					$this->addFlash('empty-diagnostic-results-' . $user->getCurrentDay()->getId(), $test->getId());

					$dCost += $test->getCost();
				}
			}

			$this->addFlash('diagnostic-cost-' . $user->getCurrentDay()->getId(), $dCost);

			$user->setCurrentProgress('therapeutics');

			$em->flush();

			if( $user->getLocation() == "Farm" )
			{
				return $this->redirectToRoute('therapeutics');
			} else if( $user->getLocation() == "Hospital" )
			{
				return $this->redirectToRoute('review');
			}
		}

		$em->flush();

		return $this->render('Default/diagnostics.html.twig', array(
			'form' => $form->createView(),
			'animal_weight' => $user->getCaseStudy()->getAnimal()->getWeight(),
		));
	}
}
