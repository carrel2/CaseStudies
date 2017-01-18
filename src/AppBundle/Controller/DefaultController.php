<?php

namespace AppBundle\Controller;

use AppBundle\Form\DefaultType;
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
		$form = $this->createForm( DefaultType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			return $this->redirectToRoute('evaluation');
		}

		return $this->render('default.html.twig', array(
			'form' => $form->createView(),
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
