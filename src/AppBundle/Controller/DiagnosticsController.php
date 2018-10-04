<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\DiagnosticProcedure;

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
		$currentDay = $user->getCurrentDay();
		$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

		if( !$user->getIsActive() || !in_array($user->getCurrentProgress(), ['evaluation', 'diagnostics']) ) {
			return $this->redirectToRoute('default');
		}

		$user->setCurrentProgress('diagnostics');

		$form = $this->createForm( 'AppBundle\Form\DiagnosticsType', null, array('category' => $day->getCaseStudy()->getAnimal()->getCategory()->getId()) );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$tests = $form->getData()['diagnosticProcedure'];

			foreach( $tests as $test )
			{
				$results = $day->getResultByDiagnosticProcedure($test);
				if( $results )
				{
					$currentDay->addDiagnosticProcedure($results);
				} else {
					$currentDay->addEmptyDiagnosticResults($test);
				}
			}

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

		$weight = $r->getSession()->has('estimated_weight') ? $r->getSession()->get('estimated_weight') : null;

		return $this->render('Default/diagnostics.html.twig', array(
			'form' => $form->createView(),
			'animal_weight' => $weight,
		));
	}

	/**
	 * @Route("/updateDiagnostics")
	 */
	function updateDiagnosticsAction(Request $r) {
		$category = $this->getDoctrine()->getManager()->getRepository("AppBundle:Category")->findOneById(1);
		foreach ($this->getDoctrine()->getManager()->getRepository("AppBundle:DiagnosticProcedure")->findAll() as $d) {
			$d->addCategory($category);
		}

		$this->getDoctrine()->getManager()->flush();

		return $this->redirectToRoute('default');
	}
}
