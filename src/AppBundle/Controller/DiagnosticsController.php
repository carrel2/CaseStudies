<?php
/**
 * src/AppBundle/Controller/TestsController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Test;
use AppBundle\Form\DiagnosticsType;

/**
 * DiagnosticsController class
 *
 * DiagnosticsController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class DiagnosticsController extends Controller
{
	/**
	 * showPageAction function
	 *
	 * Shows TestsType form. On submission adds TestResults from the corresponding Day to the current UserDay
	 *
	 * @see TestsType::class
	 * @see TestResults::class
	 * @see Day::class
	 * @see UserDay::class
	 * @see MedicationsController::showPageAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **tests.html.twig**. On submission, redirect to **MedicationsController::showPageAction()**
	 *
	 * @Route("/diagnostic", name="diagnostics")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r)
	{
		$user = $this->getUser();
		$session = $r->getSession();

		if( !$user->getIsActive() || !in_array($session->get('page'), ['evaluation', 'diagnostics']) ) {
			return $this->redirectToRoute('default');
		}

		$session->set('page', 'diagnostics');

		$form = $this->createForm( DiagnosticsType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$tests = $form->getData()['test'];

			$day = $user->getCaseStudy()->getDays()[count($user->getDays()) - 1];

			foreach( $tests as $test )
			{
				$results = $day->getResultByTest($test);
				if( $results )
				{
					$user->getCurrentDay()->addTest($results);
				} else {
					$this->addFlash('empty-diagnostic-results-' . $user->getCurrentDay()->getId(), $test->getName());
				}
			}

			$em->flush();

			$session->set('page', 'therapeutics');

			if( $user->getLocation() == "Farm" )
			{
				return $this->redirectToRoute('therapeutics');
			} else if( $user->getLocation() == "Hospital" )
			{
				return $this->redirectToRoute('review');
			}
		}

		return $this->render('Default/diagnostics.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
