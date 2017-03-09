<?php
/**
 * src/AppBundle/Controller/UserController.php
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * UserController class
 *
 * UserController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class UserController extends Controller
{
	/**
	 * registerAction function
	 *
	 * Shows UserType form. On submission, creates a new User
	 *
	 * @todo login newly registered user
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

	/**
	 * loginAction function
	 *
	 * Login page for unauthenticated User
	 *
	 * @see User::class
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **login.html.twig**
	 *
	 * @Route("/login", name="login")
	 */
	public function loginAction(Request $r)
	{
		if( $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->redirectToRoute('default');
		}

		$authenticationUtils = $this->get('security.authentication_utils');

		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('login.html.twig', array(
			'last_username' => $lastUsername,
			'error' => $error,
		));
	}

	/**
	 * userAction function
	 *
	 * Shows UserType form so authenticated User can edit object information
	 *
	 * @see UserType::class
	 * @see User::class
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **user.html.twig**
	 *
	 * @Route("/user", name="user")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function userAction(Request $r)
	{
		$user = $this->getUser();
		$form = $this->createForm( UserType::class, $user );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$user = $form->getData();

			$plainPassword = $user->getPlainPassword();

			if( strlen($plainPassword) > 6 )
			{
				$password = $this->get('security.password_encoder')
					->encodePassword($user, $plainPassword);
				$user->setPassword($password);
			}

			try {
				$em->flush();

				$this->addFlash('notice', 'Changes saved');
			} catch( \Doctrine\ORM\ORMException $e ) {
				$this->addFlash('error', 'Something went wrong, changes were not saved!');
			}
		}

		return $this->render('user.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
