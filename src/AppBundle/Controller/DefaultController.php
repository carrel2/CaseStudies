<?php

namespace AppBundle\Controller;

use AppBundle\Form\DefaultType;
use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\Session;
use AppBundle\Entity\Day;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="default")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function defaultAction(Request $r)
	{
		$user = $this->getUser();
		$case = null;

		$em = $this->getDoctrine()->getManager();

		$repo = $em->getRepository('AppBundle:Session');

		if( $session ) {
			$case = $session->getCaseStudy();
			$form = $this->createFormBuilder()
				->add('resume', SubmitType::class)
				->getForm();
		} else {
			$form = $this->createForm( DefaultType::class );
		}

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			if( !$session ) {
				$case = $form->getData()['case'];

				$day = new Day();
				$day->setNumber(1);

				$em->persist($day);

				$session = new Session();
				$session->setCaseStudy( $case );
				$session->setUser( $user );
				$session->addDay($day);
				$day->setSession($session);

				$em->persist($session);
				$em->flush();

				$user->setSession($session);
				$em->flush();
			}

			return $this->redirectToRoute('evaluation');
		}

		return $this->render('default.html.twig', array(
			'form' => $form->createView(),
			'case' => $case,
			'session' => $session,
		));
	}

	/**
	 * @Route("/getDescription/{id}", name="updateCase")
	 */
	public function updateCaseAction(Request $r, $id)
	{
		$repo = $this->getDoctrine()->getRepository('AppBundle:CaseStudy');
		$case = $repo->find($id);

		return new Response( $case->getDescription() );
	}
}
