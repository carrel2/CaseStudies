<?php

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

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="default")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function defaultAction(Request $r)
	{
		$session = $r->getSession();

		// if (time() - $session->getMetadataBag()->getLastUsed() > $this->getParameter('sessionMaxLifetime')) {
		// 	$session->set('timed out', true);
		//
    // 	return $this->redirectToRoute('logout');
		// }

		$user = $this->getUser();
		$case = $user->getCaseStudy();

		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( 'AppBundle\Form\DefaultType', $case );
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
			} else if ( $form->get('abandon')->isClicked() ) {
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
	 * @Route("/getDescription/{id}", name="updateCase")
	 */
	public function updateCaseAction(Request $r, CaseStudy $case)
	{
		return $this->render('Ajax/caseDescription.html.twig', array(
			'case' => $case,
		));
	}

	/**
	 * @Route("/reset", name="reset")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function resetAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$session = $r->getSession();
		$user = $this->getUser();

		if( $session->has('diagnosis') && $session->remove('finished') )
		{
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

				if( $session->get('differentials-' . $id) ) {
					$a[$key]["differentials"] = $session->remove('differentials-' . $id);
				}

				$results->setResults($a);
			}

			$results->setDiagnosis($session->remove('diagnosis'));
			$results->setLocation($user->getLocation());

			$em->persist($results);

			$message = \Swift_Message::newInstance()
				->setSubject("Case Study results: {$user->getCaseStudy()->getTitle()}")
				->setFrom($user->getEmail()) // TODO: consider what email(s) to send from
				->setTo('vaulter82@gmail.com') // TODO: ->setTo(admin/professor)
				->setBody(
					$this->renderView('Emails/email.html.twig', array(
						'results' => $results,
					)),
					'text/html'
				);

			$this->get('mailer')->send($message);
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
