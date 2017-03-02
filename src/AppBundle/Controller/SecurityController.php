<?php
/**
 * src/AppBundle/Controller/SecurityController.php
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * SecurityConroller class
 *
 * SecurityController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class SecurityController extends Controller
{
	/**
	 * loginAction function
	 *
	 * Login page for unauthenticated User
	 *
	 * @todo move to UserController
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
}
