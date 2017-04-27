<?php
/**
 * src/AppBundle/Controller/DefaultController.php
 */

namespace AppBundle\Controller;

use AppBundle\Form\DefaultType;
use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\UserDay;
use AppBundle\Entity\Results;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

/**
 * DefaultController class
 *
 * DefaultController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class DefaultController extends Controller
{
	/**
	 * defaultAction function
	 *
	 * Landing page for logged in User.
	 *
	 * Shows DefaultType form. Renders default.html.twig
	 *
	 * On submission, associates the current User with the selected CaseStudy unless an association already exists.
	 * Redirects to HotSpotController::showPage()
	 *
	 * @see DefaultType::class
	 * @see User::class
	 * @see CaseStudy::class
	 * @see HotSpotController::showPageAction()
	 * @see HotSpotController::resetAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **default.html.twig**. On submission, redirect to **HotSpotController::showPageAction()** or **HotSpotController::resetAction()**
	 *
	 * @Route("/", name="default")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function defaultAction(Request $r)
	{
		$session = $r->getSession();

		if (time() - $session->getMetadataBag()->getLastUsed() > $this->getParameter('sessionMaxLifetime')) {
    	$session->invalidate();

    	return $this->redirectToRoute('logout');
		}

		$user = $this->getUser();
		$case = $user->getCaseStudy();

		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( DefaultType::class, $case );
		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			if( !$case ) {
				$case = $form->getData()['title'];
				$case = $em->getRepository('AppBundle:CaseStudy')->find($case->getId());

				$case->addUser($user);
				$user->addDay(new UserDay());
				$user->setLocation($form->getData()['location']);

				$em->flush();

				$session->set('page', 'evaluation');
			} else if ( $form->get('reset')->isClicked() ) {
				return $this->redirectToRoute('reset');
			}

			$route = $session->get('page');

			if( $route == "" ) {
				$route = "evaluation";
			}

			return $this->redirectToRoute($route);
		}

		return $this->render('Default/default.html.twig', array(
			'form' => $form->createView(),
			'case' => $case,
		));
	}

	/**
	 * updateCaseAction function
	 *
	 * Called by ajax from default.html.twig to retrieve the CaseStudy information
	 *
	 * @see CaseStudy::class
	 * @see CaseStudy::getDescription()
	 *
	 * @param Request $r Request object
	 * @param CaseStudy $case
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Return **CaseStudy::getDescription()**
	 *
	 * @Route("/getDescription/{id}", name="updateCase")
	 */
	public function updateCaseAction(Request $r, CaseStudy $case)
	{
		return $this->render('Ajax/caseDescription.html.twig', array(
			'case' => $case,
		));
	}

	/**
	 * resetAction function
	 *
	 * Function to remove the association between the current User and CaseStudy
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
	public function resetAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$session = $r->getSession();
		$user = $this->getUser();

		if( $session->remove('finished') )
		{
			if( !$session->has('diagnosis') )
			{
				return $this->redirectToRoute('review');
			}

			$results = new Results();

			$user->addResult($results);
			$results->setCaseStudy($user->getCaseStudy()->getTitle());

			foreach($user->getDays() as $key => $day)
			{
				$id = $day->getId();

				$results->add($day->toArray());

				$a = $results->getResults();

				foreach ($session->getFlashBag()->get('hotspot-' . $id) as $flash) {
					$a[$key]["hotspotsInfo"][$flash] = "No results available.";
				}
				foreach ($session->getFlashBag()->get('empty-diagnostic-results-' . $id) as $flash) {
					$a[$key]["diagnostics"][$flash] = "No results available.";
				}
				foreach ($session->getFlashBag()->get('empty-therapeutic-results-' . $id) as $flash) {
					$a[$key]["therapeutics"][$flash] = "No results available.";
				}

				$results->setResults($a);
			}

			$results->setDiagnosis($session->remove('diagnosis'));
			$results->setLocation($user->getLocation());

			$em->persist($results);
		}

		$session->clear();

		$user->setCaseStudy(null);
		$user->removeDays();

		$session->getFlashBag()->clear();

		$em->flush();

		return $this->redirectToRoute('default');
	}

	/**
	 * @Route("/removeResult/{id}")
	 */
	public function removeResultsAction(Request $r, Results $result)
	{
		$em = $this->getDoctrine()->getManager();

		$em->remove($result);
		$em->flush();

		return $this->redirectToRoute('default');
	}
}
