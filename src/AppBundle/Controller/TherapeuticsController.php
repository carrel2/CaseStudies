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
		$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

		if( !$user->getIsActive() || $user->getCurrentProgress() != 'therapeutics' ) {
			return $this->redirectToRoute('default');
		}

		$weight = $user->getEstimatedWeight();

		$form = $this->createForm( 'AppBundle\Form\TherapeuticsType', null, array('category' => $day->getCaseStudy()->getAnimal()->getCategory()->getId()) );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$medications = $form->getData()['therapeuticProcedure'];

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

	/**
	 * @Route("/updateTherapeutics")
	 */
	function updateTherapeuticsAction(Request $r) {
		$category = $this->getDoctrine()->getManager()->getRepository("AppBundle:Category")->findOneById(1);
		foreach ($this->getDoctrine()->getManager()->getRepository("AppBundle:TherapeuticProcedure")->findAll() as $t) {
			$t->addCategory($category);
		}

		$this->getDoctrine()->getManager()->flush();

		return $this->redirectToRoute('default');
	}
}
