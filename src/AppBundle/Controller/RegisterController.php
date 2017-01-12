<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
	/**
	 * @Route("/register", name="registration")
	 */
	public function registerAction(Request $request)
	{
		$user = new User();

		$form = $this->createForm( UserType::class, $user );

		$form->handleRequest($request);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$password = $this->get('security.password_encoder')
				->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($password);

			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			return $this->redirectToRoute('default');
		}

		return $this->render('register.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
