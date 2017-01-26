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

		$day = new Day();
		$day->setNumber(1);

		$form = $this->createForm( DefaultType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($day);
			$em->flush();

			$days = array($day,);

			$case = $form->getData()['case'];
			$repo = $em->getRepository('AppBundle:Session');

			$q = $repo->createQueryBuilder('b')
				->where('b.caseId = :cid AND b.userId = :uid')
				->setParameter('cid', $case->getId() )
				->setParameter('uid', $user->getId())
				->getQuery();

			$session = $q->setMaxResults(1)->getOneOrNullResult();

			if( !$session ) {
				$session = new Session();
				$session->setCaseId( $case->getId() );
				$session->setUserId( $user->getId() );
				$session->setDays($days);

				$em->persist($session);
				$em->flush();
			}

			$r->getSession()->set('session', $session->getId());

			return $this->redirectToRoute('evaluation');
		}

		return $this->render('default.html.twig', array(
			'form' => $form->createView(),
			'case' => $case,
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
