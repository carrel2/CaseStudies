<?php
/**
 * src/AppBundle/Controller/DayController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\UserDay;

/**
 * DayController class
 *
 * DayController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class DayController extends Controller
{
	/**
	 * reviewAction function
	 *
	 * Renders review.html.twig
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **review.html.twig**
	 *
	 * @Route("/review", name="review")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function reviewAction(Request $r)
	{
		$user = $this->getUser();
		$days = $user->getDays();

		return $this->render('review.html.twig', array(
			'user' => $user,
			'days' => $days,
		));
	}

	/**
	 * logicAction function
	 *
	 * Function to handle the logic between Day objects
	 *
	 * @see Day::class 
	 *
	 * @todo add code to control logic between days
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function logicAction(Request $r)
	{
		return null;
	}

	/**
	 * nextAction function
	 *
	 * Creates a new UserDay for the User and redirects to evaluation page
	 *
	 * @see UserDay::class
	 * @see User::class
	 * @see HotSpotController::showPageAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Redirect to **HotSpotController::showPageAction()**
	 *
	 * @Route("/nextDay", name="nextDay")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function nextAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		$user->addDay(new UserDay());

		$em->flush();

		return $this->redirectToRoute('evaluation');
	}
}
