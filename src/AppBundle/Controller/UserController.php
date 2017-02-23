<?php
// src/AppBundle/Controller/UserController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AdminUserType;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserController extends Controller
{
	/**
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
				//add flash messages
			}

			$em->flush();
		}

		return $this->render('user.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * @Route("/admin/users", name="adminUsers")
	 */
	public function adminUserAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();
		$users = $em->getRepository('AppBundle:User')->findAll();

		$builder = $this->createFormBuilder();

		foreach($users as $user) {
			$builder->add('id' . $user->getId(), HiddenType::class, array(
				'data' => $user->getId()));
		}

		$form = $builder->getForm();

		return $this->render('adminUser.html.twig', array(
			'form' => $form->createView(),
			'users' => $users,
		));
	}

	/**
	 * @Route("/admin/users/edit/{id}", name="editUser")
	 */
	public function editUserAction(Request $r, User $user)
	{
		$form = $this->createForm( UserType::class, $user );

		return $this->render('user.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
