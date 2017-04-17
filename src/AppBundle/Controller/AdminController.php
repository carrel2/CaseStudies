<?php
/**
 * src/AppBundle/Controller/AdminController.php
 *
 * Controller for admin actions
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\AdminUserType;
use AppBundle\Form\UserType;
use AppBundle\Form\AdminType;
use AppBundle\Form\CaseType;
use AppBundle\Form\AnimalType;
use AppBundle\Form\TestType;
use AppBundle\Form\MedicationType;
use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\User;
use AppBundle\Entity\Animal;
use AppBundle\Entity\Test;
use AppBundle\Entity\Medication;

/**
 * AdminController class
 *
 * AdminController class extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
 *
 * @see http://api.symfony.com/3.2/Symfony/Bundle/FrameworkBundle/Controller/Controller.html
 */
class AdminController extends Controller
{
	/**
	 * adminAction function
	 *
	 * Default admin action. Renders admin.html.twig template
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **admin.html.twig**
	 *
	 * @Route("/admin", name="admin")
	 */
	public function adminAction(Request $r)
	{
		return $this->render('admin.html.twig', array(
			'form' => null,
		));
	}

	/**
	 * editCaseAction function
	 *
	 * Creates a form for admins to use to edit CaseStudy objects
	 *
	 * @see CaseStudy::class
	 *
	 * @todo add undo functionality
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **editCase.html.twig**
	 *
	 * @Route("/admin/edit/case", name="editCase")
	 */
	public function editCaseAction(Request $r)
	{
		$form = $this->createForm( AdminType::class );

		$form->handleRequest($r);

		return $this->render('Admin/editCase.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * createCaseAction function
	 *
	 * Shows CaseType form for admins to create a new CaseStudy
	 *
	 * @see CaseType::class
	 * @see CaseStudy::class
	 * @see AdminController::adminAction()
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **createCase.html.twig**. On submission, redirect to **AdminController::adminAction()**
	 *
	 * @Route("/admin/create/case", name="createCase")
	 */
	public function createCaseAction(Request $r)
	{
		$form = $this->createForm( CaseType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$case = $form->getData();

			$em->persist($case);
			$em->flush();

			$this->addFlash('notice', 'Created ' . $case->getTitle());

			return $this->redirectToRoute('admin');
		}

		return $this->render('Admin/createCase.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * getCaseAction function
	 *
	 * Function to get a case study and all information associated with it. Called through ajax.
	 * Returns caseInfo.html.twig template
	 *
	 * @todo add confirmation for delete
	 *
	 * @param Request $r Request object
	 * @param CaseStudy $case CaseStudy object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **caseInfo.html.twig**. On submission, redirect to **AdminController::editCaseAction()**
	 *
	 * @Route("/getCase/{id}", name="caseInfo")
	 */
	public function getCaseAction(Request $r, CaseStudy $case)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( CaseType::class, $case );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$case = $form->getData();

			if( $form->get('update')->isClicked() ) {
				$this->addFlash('notice', 'Updated ' . $case->getTitle());

				$em->persist($case);
			} else if( $form->get('delete')->isClicked() ) {
				$this->addFlash('notice', 'Deleted ' . $case->getTitle());

				$em->remove($case);
			}

			$em->flush();

			$r->getSession()->set('case', $case->getId());

			return $this->redirectToRoute('editCase');
		}

		return $this->render('Ajax/caseInfo.html.twig', array(
			'form' => $form->createView(),
			'case' => $case,
			'id' => $case->getId(),
		));
	}

	/**
	 * manageUsersAction function
	 *
	 * Allows admin User to edit User objects
	 *
	 * @todo style checkboxes
	 *
	 * @see User::class
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **adminUser.html.twig**
	 *
	 * @Route("/admin/users", name="manageUsers")
	 */
	public function manageUsersAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createFormBuilder()->add('users', EntityType::class,
			array(
				'class' => 'AppBundle:User',
				'choice_label' => 'username',
				'expanded' => true,))
			->add('edit', SubmitType::class)
			->add('delete', SubmitType::class)->getForm();

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() ) {
			$user = $form->getData()['users'];

			if( $form->get('edit')->isClicked() ) {
				return $this->redirectToRoute('editUser', array(
					'id' => $user->getId(),
				));
			} else if( $form->get('delete')->isClicked() ) {
				$em->remove($user);
				$this->addFlash('notice', 'User deleted: ' . $user->getUsername());
				$em->flush();

				return $this->redirectToRoute('manageUsers');
			}
		}

		return $this->render('admin.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * editUserAction function
	 *
	 * Edit selected User object
	 *
	 * @param Request $r Request object
	 * @param User $user
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **user.html.twig**
	 *
	 * @Route("/admin/edit/users/{id}", name="editUser")
	 */
	public function editUserAction(Request $r, User $user)
	{
		$form = $this->createForm( UserType::class, $user );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() ) {
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

				$this->addFlash('notice', 'Changes saved for ' . $user->getUsername() );
			} catch( \Doctrine\ORM\ORMException $e ) {
				$this->addFlash('error', 'Something went wrong, changes were not saved!');
			}

			return $this->redirectToRoute('manageUsers');
		}

		return $this->render('admin.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * @todo manage images associated with the animal
	 * @todo add confirmation for delete
	 *
	 * @Route("/admin/animals", name="manageAnimals")
	 */
	public function animalAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createFormBuilder()
			->add('animals', EntityType::class, array(
				'class' => 'AppBundle:Animal',
				'choice_label' => 'name',
				'expanded' => true,
			))
			->add('edit', SubmitType::class)
			->add('delete', SubmitType::class)->getForm();

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$animal = $form->getData()['animals'];

			if( $form->get('edit')->isClicked() ) {
				return $this->redirectToRoute('editAnimal', array('id' => $animal->getId()));
			} else if( $form->get('delete')->isClicked() ) {
				$em->remove($animal);
				$em->flush();

				return $this->redirectToRoute('manageAnimals');
			}
		}

		return $this->render('Admin/animals.html.twig', array(
			'form' => $form->createView(),
			'animal' => null,
		));
	}

	/**
	 * @Route("/admin/create/animal", name="createAnimal")
	 */
	public function createAnimalAction(Request $r)
	{
		$form = $this->createForm( AnimalType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();

			$em->persist($animal);

			$em->flush();
		}

		return $this->render('Admin/animals.html.twig', array(
			'form' => $form->createView(),
			'animal' => null,
		));
	}

	/**
	 * @Route("/admin/edit/animals/{id}", name="editAnimal")
	 */
	 public function hotspotsAction(Request $r, Animal $animal = null)
	 {
		 if( $animal === null )
		 {
			 $animal = new Animal();
		 }

		 $form = $this->createForm( AnimalType::class, $animal );

		 $form->handleRequest($r);

		 if( $form->isSubmitted() && $form->isValid() )
		 {
			 $em = $this->getDoctrine()->getManager();

			 $em->persist($animal);

			 $em->flush();
		 }

		 return $this->render('Admin/animals.html.twig', array(
			 'form' => $form->createView(),
			 'animal' => $animal,
		 ));
	 }

	 /**
	  * @Route("/admin/tests", name="manageTests")
		*/
		public function testsAction(Request $r)
		{
			$em = $this->getDoctrine()->getManager();

			$form = $this->createFormBuilder()
				->add('tests', EntityType::class, array(
					'class' => 'AppBundle:Test',
					'choice_label' => 'name',
					'expanded' => true,
				))
				->add('edit', SubmitType::class)
				->add('delete', SubmitType::class)->getForm();

			$form->handleRequest($r);

			if( $form->isSubmitted() && $form->isValid() )
			{
				$test = $form->getData()['tests'];

				if( $form->get('edit')->isClicked() ) {
					return $this->redirectToRoute('editTest', array('id' => $test->getId()));
				} else if( $form->get('delete')->isClicked() ) {
					$em->remove($test);
					$em->flush();

					return $this->redirectToRoute('manageTests');
				}
			}

			return $this->render('Admin/manage.html.twig', array(
				'form' => $form->createView(),
			));
		}

		/**
		 * @Route("/admin/create/test", name="createTest")
		 */
		public function createTestAction(Request $r)
		{
			$form = $this->createForm( TestType::class );

			$form->handleRequest($r);

			if( $form->isSubmitted() && $form->isValid() )
			{
				$em = $this->getDoctrine()->getManager();

				$em->persist($test);

				$em->flush();
			}

			return $this->render('Admin/manage.html.twig', array(
				'form' => $form->createView(),
				'test' => null,
			));
		}

		/**
		 * @Route("/admin/edit/tests/{id}", name="editTest")
		 */
		 public function editTestAction(Request $r, Test $test = null)
		 {
			 if( $test === null )
			 {
				 $test = new Test();
			 }

			 $form = $this->createForm( TestType::class, $test );

			 $form->handleRequest($r);

			 if( $form->isSubmitted() && $form->isValid() )
			 {
				 $em = $this->getDoctrine()->getManager();

				 $em->persist($test);

				 $em->flush();
			 }

			 return $this->render('Admin/manage.html.twig', array(
				 'form' => $form->createView(),
				 'test' => $test,
			 ));
		 }

		 /**
		  * @Route("/admin/medications", name="manageMedications")
			*/
			public function medicationsAction(Request $r)
			{
				$em = $this->getDoctrine()->getManager();

				$form = $this->createFormBuilder()
					->add('medications', EntityType::class, array(
						'class' => 'AppBundle:Medication',
						'choice_label' => 'name',
						'expanded' => true,
					))
					->add('edit', SubmitType::class)
					->add('delete', SubmitType::class)->getForm();

				$form->handleRequest($r);

				if( $form->isSubmitted() && $form->isValid() )
				{
					$medication = $form->getData()['medications'];

					if( $form->get('edit')->isClicked() ) {
						return $this->redirectToRoute('editMedication', array('id' => $medication->getId()));
					} else if( $form->get('delete')->isClicked() ) {
						$em->remove($medication);
						$em->flush();

						return $this->redirectToRoute('manageMediations');
					}
				}

				return $this->render('Admin/manage.html.twig', array(
					'form' => $form->createView(),
				));
			}

			/**
			 * @Route("/admin/create/medication", name="createMedication")
			 */
			public function createMedicationAction(Request $r)
			{
				$form = $this->createForm( MedicationType::class );

				$form->handleRequest($r);

				if( $form->isSubmitted() && $form->isValid() )
				{
					$em = $this->getDoctrine()->getManager();

					$em->persist($medication);

					$em->flush();
				}

				return $this->render('Admin/manage.html.twig', array(
					'form' => $form->createView(),
					'medication' => null,
				));
			}

			/**
			 * @Route("/admin/edit/medications/{id}", name="editMedication")
			 */
			 public function editMedicationAction(Request $r, Medication $medication = null)
			 {
				 if( $medication === null )
				 {
					 $medication = new Medication();
				 }

				 $form = $this->createForm( MedicationType::class, $medication );

				 $form->handleRequest($r);

				 if( $form->isSubmitted() && $form->isValid() )
				 {
					 $em = $this->getDoctrine()->getManager();

					 $em->persist($medication);

					 $em->flush();
				 }

				 return $this->render('Admin/manage.html.twig', array(
					 'form' => $form->createView(),
					 'medication' => $test,
				 ));
			 }
}
