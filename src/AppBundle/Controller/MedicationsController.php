<?php
/**
 * src/AppBundle/Controller/MedicationsController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\MedicationsType;

/**
 * MedicationsController class
 *
 * MedicationsController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class MedicationsController extends Controller
{
	/**
	 * showPageAction function
	 *
	 * Shows MedicationsType form. On submission, adds MedicationResults from the corresponding Day to the current UserDay
	 *
	 * @see MedicationsType::class
	 * @see MedicationResults::class
	 * @see Day::class
	 * @see UserDay::class
	 * @see DayController::reviewAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **medications.html.twig**. On submission, redirect to **DayController::logicAction()**
	 *
	 * @Route("/medications", name="order_meds")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPageAction(Request $r)
	{
		$user = $this->getUser();
		$session = $r->getSession();

		if( !$user->getIsActive() || $session->get('page') != 'order_meds' ) {
			return $this->redirectToRoute('default');
		}

		$form = $this->createForm( MedicationsType::class );

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
					$this->addFlash('empty-medication-results-' . $user->getCurrentDay()->getId(), $medication->getName());
				}
			}

			$em->flush();

			$session->set('page', 'review');

			return $this->redirectToRoute('logic');
		}

		return $this->render('medications.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
