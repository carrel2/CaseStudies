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
	 * userAction function
	 *
	 * Shows UserType form so authenticated User can edit object information
	 *
	 * @todo add flash messages to notify User that an error occurred
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

			$em->flush();

			$this->addFlash('notice', 'Changes saved');
		}

		return $this->render('user.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
