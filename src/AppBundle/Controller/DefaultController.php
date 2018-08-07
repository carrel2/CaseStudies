<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\UserDay;
use AppBundle\Entity\Results;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="default")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function defaultAction(Request $r)
	{
		$session = $r->getSession();

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
				$user->setCurrentProgress("evaluation");

				$em->flush();

			} else if ( $form->get('abandon')->isClicked() ) {
				return $this->redirectToRoute('reset');
			}

			if( $user->getCurrentProgress() == "" ) {
				$user->setCurrentProgress("evaluation");
			}

			$em->flush();

			$route = $user->getCurrentProgress();

			if( $route == "finished" ) {
				$route = "review";
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
		$case = $user->getCaseStudy();
		$addFlash = false;

		if( $session->has('diagnosis-' . $user->getCurrentDay()->getId()) && $user->getCurrentProgress() == "finished" )
		{
			$results = new Results();

			$user->addResult($results);
			$results->setCaseStudy($case->getTitle());

			foreach($user->getDays() as $key => $day)
			{
				$id = $day->getId();

				$results->add($day->toArray());

				$a = $results->getResults();

				foreach ($session->getFlashBag()->get('hotspot-' . $id) as $flash) {
					$a[$key]["hotspotsInfo"][$flash["name"]] = "No results available.";
				}
				foreach ($session->getFlashBag()->get('empty-diagnostic-results-' . $id) as $flash) {
					$dFlash = $em->getRepository("AppBundle:DiagnosticProcedure")->find($flash);

					$a[$key]["diagnostics"][$dFlash->getName()] = $dFlash->getDefaultResult();
				}
				foreach ($session->getFlashBag()->get('empty-therapeutic-results-' . $id) as $flash) {
					$tFlash = $em->getRepository("AppBundle:TherapeuticProcedure")->find($flash);

					$a[$key]["therapeutics"][$tFlash->getName()] = $tFlash->getDefaultResult();
				}

				if( $session->get('diagnosis-' . $id) ) {
					$a[$key]["diagnosis"] = $session->remove('diagnosis-' . $id);
				}

				if( $session->get('differentials-' . $id) ) {
					$a[$key]["differentials"] = $session->remove('differentials-' . $id);
				}

				$results->setResults($a);
			}

			$results->setLocation($user->getLocation());

			$em->persist($results);

			$message = \Swift_Message::newInstance()
				->setSubject("Case Study results: {$user->getCaseStudy()->getTitle()}")
				->setFrom('casestudies@vetmed.illinois.edu')
				->setTo($case->getEmail())
				->setBody(
					$this->renderView('Emails/email.html.twig', array(
						'results' => $results,
					)),
					'text/html'
				);

			$this->get('mailer')->send($message);

			$addFlash = true;
		}

		$session->clear();

		$user->setCaseStudy();
		$user->setCurrentProgress();
		$user->removeDays();

		$session->getFlashBag()->clear();

		$em->flush();

		if( $addFlash ) {
			$this->addFlash('results', $case->getTitle());
		}

		return $this->redirectToRoute('default');
	}

	/**
	 * @Route("/removeResult/{id}")
	 */
	public function removeResultsAction(Request $r, Results $result)
	{
		$em = $this->getDoctrine()->getManager();

		$uid = $result->getUser()->getId();

		$em->remove($result);
		$em->flush();

		$this->addFlash('success', 'Result removed');

		return $this->redirectToRoute('editUserResults', array(
			'id' => $uid,
		));
	}
}
