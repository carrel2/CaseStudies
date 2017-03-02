<?php
/**
 * src/AppBundle/Controller/RegisterController.php
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * RegisterController class
 *
 * RegisterController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class RegisterController extends Controller
{
	/**
	 * registerAction function
	 *
	 * Shows UserType form. On submission, creates a new User
	 *
	 * @todo move to UserController
	 *
	 * @see UserType::class
	 * @see User::class
	 * @see DefaultController::defaultAction()
	 *
	 * @param Request $request Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **register.html.twig**. On submission, redirect to **DefaultController::defaultAction()**
	 *
	 * @Route("/registration", name="registration")
	 */
	public function registerAction(Request $request)
	{
		if( $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->redirectToRoute('default');
		}

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
