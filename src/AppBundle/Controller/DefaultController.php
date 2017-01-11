<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Session;
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

		if( $form->isSubmitted() && $form->isValid() ) {
			$user = $form->getData();
			$session = new Session();
			$session->setName($user->getName());
			$session->setEmail($user->getEmail());

			$em = $this->getDoctrine()->getManager();
			$em->persist($session);
			$em->flush();

			return $this->redirectToRoute('evaluation');
		}

		return $this->render('homepage.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
