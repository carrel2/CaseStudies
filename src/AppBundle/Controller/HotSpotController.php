<?php
/**
 * src/AppBundle/Controller/HotSpotController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\HotSpots;

/**
 * HotSpotController class
 *
 * HotSpotController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class HotSpotController extends Controller
{
	/**
	 * showPageAction function
	 *
	 * Evaluation page. Retrieves all HotSpots from the current Day of the associated CaseStudy.
	 *
	 * @todo add image functionality for HotSpots
	 * @todo research 3d model functionality for HotSpots
	 *
	 * @see HotSpots::class
	 * @see Day::class
	 * @see CaseStudy::class
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **hotspot.html.twig**
	 *
	 * @Route("/eval", name="evaluation")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showPageAction(Request $r)
	{
		$user = $this->getUser();
		$session = $r->getSession();

		if( !$user->getIsActive() || $session->get('page') != 'evaluation' ) {
			return $this->redirectToRoute('default');
		}

		$case = $user->getCaseStudy();
		$days = $case->getDays();
		$hotspots = $days[count($user->getDays()) - 1]->getHotspots();

		return $this->render('hotspot.html.twig', array(
			'hotspots' => $hotspots,
			'checked' => $user->getCurrentDay()->getHotspots(),
		));
	}

	/**
	 * updatePageAction function
	 *
	 * Called by ajax. Function to update UserDay with the HotSpots given
	 *
	 * @see HotSpots::class
	 * @see UserDay::class
	 *
	 * @param Request $r Request object
	 * @param HotSpots $hotspot The HotSpots to add to the current UserDay
	 *
	 * @return \Symfony\Component\HttpFoundation\Response If $hotspot was added to the **UserDay**, returns name and info. Returns empty string otherwise
	 *
	 * @Route("/update/{id}", name="update")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function updatePageAction(Request $r, HotSpots $hotspot)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$hotspots = $user->getCurrentDay()->getHotspots();

		if( $hotspots->contains( $hotspot ) ) {
			return new Response('');
		}

		$user->getCurrentDay()->addHotspot($hotspot);

		$em->flush();

		return new Response('<li>' . $hotspot->getName() . ': ' . $hotspot->getInfo() . '</li>');
	}

	/**
	 * resetPageAction function
	 *
	 * Function to remove the association between the current User and CaseStudy
	 *
	 * @todo move to DefaultController
	 *
	 * @see User::class
	 * @see CaseStudy::class
	 * @see HotSpotController::showPageAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Redirect to **HotSpotController::showPageAction()**
	 *
	 * @Route("/reset", name="reset")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function resetPageAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();

		$user->setCaseStudy(null);
		$user->removeDays();

		$r->getSession()->remove('finished');
		$r->getSession()->getFlashBag()->clear();

		$em->flush();

		return $this->redirectToRoute('default');
	}
}
