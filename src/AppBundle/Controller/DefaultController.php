<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction(Request $request)
	{
		$user = new User();

		$form = $this->createForm( UserType::class, $user );

		$form->handleRequest($request);

		if( $form->isSubmitted() ) {
			$user = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$repo = $this->getDoctrine()->getRepository('AppBundle:User');

			$u = $repo->findOneByName($user->getName());

			if( !$u ) {
				$em->persist($user);
				$em->flush();
			}

			$u = $repo->findOneByName($user->getName());

			return $this->redirectToRoute('evaluation', array( 'user' => $u->getId() ));
		}

		return $this->render('homepage.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
