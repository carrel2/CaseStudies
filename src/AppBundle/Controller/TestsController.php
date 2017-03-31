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
use AppBundle\Form\TestsType;

/**
 * TestsController class
 *
 * TestsController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class TestsController extends Controller
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
	 * @Route("/tests", name="order_tests")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPage(Request $r)
	{
		$user = $this->getUser();
		$session = $r->getSession();

		if( !$user->getIsActive() || !in_array($session->get('page'), ['evaluation', 'order_tests']) ) {
			return $this->redirectToRoute('default');
		}

		$session->set('page', 'order_tests');

		$form = $this->createForm( TestsType::class );

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
					$this->addFlash('empty-test-results-' . $user->getCurrentDay()->getId(), $test->getName());
				}
			}

			$em->flush();

			$session->set('page', 'order_meds');

			return $this->redirectToRoute('order_meds');
		}

		return $this->render('Default/tests.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
