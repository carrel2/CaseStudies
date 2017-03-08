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
	 * @todo handle null TestResults
	 * @todo redirect to default if no case associated with the user
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
		$session = $r->getSession();
		$session->set('page', 'order_tests');

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
				$results = $day->getResultByTest($test);
				if( $results )
				{
					$user->getCurrentDay()->addTest($day->getResultByTest($test));
				} else {}
			}

			$em->flush();

			return $this->redirectToRoute('order_meds');
		}

		return $this->render('tests.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
