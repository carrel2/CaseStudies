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
use AppBundle\Form\DiagnosticType;
use AppBundle\Form\TherapeuticType;
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

			$this->addFlash('success', 'Created ' . $case->getTitle());

			$r->getSession()->set('case', $case->getId());

			return $this->redirectToRoute('editCase');
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
				$this->addFlash('success', 'Updated ' . $case->getTitle());

				$em->persist($case);
			} else if( $form->get('delete')->isClicked() ) {
				$this->addFlash('success', 'Deleted ' . $case->getTitle());

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
	 * @see User::class
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **admin.html.twig**
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
				'expanded' => true,
			))
			->add('edit', SubmitType::class, array(
				'attr' => array('class' => 'is-success'),
			))
			->add('delete', SubmitType::class, array(
				'attr' => array(
					'class' => 'is-danger',
					'onclick' => 'return confirmDelete();',
				),
			))->getForm();

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() ) {
			$user = $form->getData()['users'];

			if( $form->get('edit')->isClicked() ) {
				return $this->redirectToRoute('editUser', array(
					'id' => $user->getId(),
				));
			} else if( $form->get('delete')->isClicked() ) {
				$em->remove($user);
				$this->addFlash('success', 'Deleted ' . $user->getUsername());
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

				$this->addFlash('success', 'Changes saved for ' . $user->getUsername() );
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
	 * editUserResultsAction function
	 *
	 * Allows admin User to edit Results objects associated with another User
	 *
	 * @param Request $r Request object
	 * @param User $user User object to edit
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **results.html.twig**
	 *
	 * @Route("/admin/edit/users/{id}/results", name="editUserResults")
	 */
	public function editUserResultsAction(Request $r, User $user)
	{
		$em = $this->getDoctrine()->getManager();
		$results = $em->getRepository('AppBundle:Results')->findByUser($user);

		return $this->render('Default/results.html.twig', array(
			'user' => $user,
			'results' => $results,
		));
	}

	/**
	 * animalAction function
	 *
	 * Allows admin User to edit Animal objects
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **manage.html.twig**
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
			->add('edit', SubmitType::class, array(
				'attr' => array('class' => 'is-success'),
			))
			->add('delete', SubmitType::class, array(
				'attr' => array(
					'class' => 'is-danger',
					'onclick' => 'return confirmDelete();',
				),
			))->getForm();

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$animal = $form->getData()['animals'];

			if( $form->get('edit')->isClicked() ) {
				return $this->redirectToRoute('editAnimal', array('id' => $animal->getId()));
			} else if( $form->get('delete')->isClicked() ) {
				$em->remove($animal);
				$em->flush();

				$this->addFlash('success', 'Deleted ' . $animal->getName());

				return $this->redirectToRoute('manageAnimals');
			}
		}

		return $this->render('Admin/manage.html.twig', array(
			'form' => $form->createView(),
			'animal' => null,
			'route' => 'createAnimal',
		));
	}

	/**
	 * createAnimalAction function
	 *
	 * Allows admin User to create new Animal object
	 *
	 * @param Request $r Request object
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **animals.html.twig**
	 *
	 * @Route("/admin/create/animal", name="createAnimal")
	 */
	public function createAnimalAction(Request $r)
	{
		$form = $this->createForm( AnimalType::class );

		$form->handleRequest($r);

		if( $form->isSubmitted() && $form->isValid() )
		{
			$em = $this->getDoctrine()->getManager();
			$animal = $form->getData();

			$em->persist($animal);

			$em->flush();

			$this->addFlash('success', 'Created ' . $animal->getName());

			return $this->redirectToRoute('editAnimal', array('id' => $animal->getId()));
		}

		return $this->render('Admin/animals.html.twig', array(
			'form' => $form->createView(),
			'animal' => null,
			'route' => null,
		));
	}

	/**
	 * hotspotsAction function
	 *
	 * Allows admin User to edit HotSpot objects associated with an Animal object
	 *
	 * @param Request $r Request object
	 * @param Animal $animal Animal object to edit
	 *
	 * @return \Symfony\Component\HttpFoundation\Response Render **animals.html.twig**
	 *
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

			 $this->addFlash('success', 'Updated ' . $animal->getName());

			 return $this->redirectToRoute('editAnimal', array('id' => $animal->getId()));
		 }

		 return $this->render('Admin/animals.html.twig', array(
			 'form' => $form->createView(),
			 'animal' => $animal,
			 'route' => null,
		 ));
	 }

	 /**
	  * testsAction function
		*
		* Allows admin User to edit Test objects
		*
		* @param Request $r Request object
		*
		* @return \Symfony\Component\HttpFoundation\Response Render **manage.html.twig**
		*
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
					'choice_attr' => function(Test $t, $key, $index) {
						return ['class' => 'test'];
					},
					'group_by' => function($val, $key, $index) {
						return $val->getGroup();
					},
					'label_attr' => array(
						'class' => ' tests_label',
					)
				))
				->add('edit', SubmitType::class, array(
					'attr' => array('class' => 'is-success'),
				))
				->add('delete', SubmitType::class, array(
					'attr' => array(
						'class' => 'is-danger',
						'onclick' => 'return confirmDelete();',
					),
				))->getForm();

			$form->handleRequest($r);

			if( $form->isSubmitted() && $form->isValid() )
			{
				$test = $form->getData()['tests'];

				if( $form->get('edit')->isClicked() ) {
					return $this->redirectToRoute('editTest', array('id' => $test->getId()));
				} else if( $form->get('delete')->isClicked() ) {
					$em->remove($test);
					$em->flush();

					$this->addFlash('success', 'Deleted ' . $test->getName());

					return $this->redirectToRoute('manageTests');
				}
			}

			return $this->render('Admin/manage.html.twig', array(
				'form' => $form->createView(),
				'route' => 'createTest',
			));
		}

		/**
		 * createTestAction function
		 *
		 * Allows admin User to create new Test object
		 *
		 * @param Request $r Request object
		 *
		 * @return \Symfony\Component\HttpFoundation\Response Render **manage.html.twig**
		 *
		 * @Route("/admin/create/test", name="createTest")
		 */
		public function createTestAction(Request $r)
		{
			$form = $this->createForm( DiagnosticType::class );

			$form->handleRequest($r);

			if( $form->isSubmitted() && $form->isValid() )
			{
				$em = $this->getDoctrine()->getManager();

				$em->persist($test);

				$em->flush();

				$this->addFlash('success', 'Created ' . $test->getName());
			}

			return $this->render('Admin/manage.html.twig', array(
				'form' => $form->createView(),
				'route' => null,
			));
		}

		/**
		 * editTestAction function
		 *
		 * Allow admin User to edit Test object
		 *
		 * @param Request $r Request object
		 * @param Test $test Test object to edit
		 *
		 * @return \Symfony\Component\HttpFoundation\Response Render **manage.html.twig**
		 *
		 * @Route("/admin/edit/tests/{id}", name="editTest")
		 */
		 public function editTestAction(Request $r, Test $test = null)
		 {
			 if( $test === null )
			 {
				 $test = new Test();
			 }

			 $form = $this->createForm( DiagnosticType::class, $test );

			 $form->handleRequest($r);

			 if( $form->isSubmitted() && $form->isValid() )
			 {
				 $em = $this->getDoctrine()->getManager();

				 $em->persist($test);

				 $em->flush();

				 $this->addFlash('success', 'Updated ' . $test->getName());
			 }

			 return $this->render('Admin/manage.html.twig', array(
				 'form' => $form->createView(),
				 'route' => null,
			 ));
		 }

		 /**
		  * medicationsAction function
			*
			* Allows admin User to manage Medication objects
			*
			* @param Request $r Request object
			*
			* @return \Symfony\Component\HttpFoundation\Response Render **manage.html.twig**
			*
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
						'choice_attr' => function(Medication $t, $key, $index) {
							return ['class' => 'medication'];
						},
						'group_by' => function($val, $key, $index) {
							return $val->getGroup();
						},
						'label_attr' => array(
							'class' => 'medications_label',
						)
					))
					->add('edit', SubmitType::class, array(
						'attr' => array('class' => 'is-success'),
					))
					->add('delete', SubmitType::class, array(
						'attr' => array(
							'class' => 'is-danger',
							'onclick' => 'return confirmDelete();',
						),
					))->getForm();

				$form->handleRequest($r);

				if( $form->isSubmitted() && $form->isValid() )
				{
					$medication = $form->getData()['medications'];

					if( $form->get('edit')->isClicked() ) {
						return $this->redirectToRoute('editMedication', array('id' => $medication->getId()));
					} else if( $form->get('delete')->isClicked() ) {
						$em->remove($medication);
						$em->flush();

						$this->addFlash('success', 'Deleted ' . $medication->getName());

						return $this->redirectToRoute('manageMediations');
					}
				}

				return $this->render('Admin/manage.html.twig', array(
					'form' => $form->createView(),
					'route' => 'createMedication',
				));
			}

			/**
			 * createMedicationAction function
			 *
			 * Allows admin User to create a new Medication object
			 *
			 * @param Request $r Request object
			 *
			 * @return \Symfony\Component\HttpFoundation\Response Render **manage.html.twig**
			 *
			 * @Route("/admin/create/medication", name="createMedication")
			 */
			public function createMedicationAction(Request $r)
			{
				$form = $this->createForm( TherapeuticType::class );

				$form->handleRequest($r);

				if( $form->isSubmitted() && $form->isValid() )
				{
					$em = $this->getDoctrine()->getManager();

					$em->persist($medication);

					$em->flush();

					$this->addFlash('success', 'Created ', $medication->getName());
				}

				return $this->render('Admin/manage.html.twig', array(
					'form' => $form->createView(),
					'route' => null,
				));
			}

			/**
			 * editMedicationAction function
			 *
			 * Allows adminUser to edit Medication object
			 *
			 * @param Request $r Request object
			 * @param Medication $medication Medication object to edit
			 *
			 * @return \Symfony\Component\HttpFoundation\Response Render **manage.html.twig**
			 *
			 * @Route("/admin/edit/medications/{id}", name="editMedication")
			 */
			 public function editMedicationAction(Request $r, Medication $medication = null)
			 {
				 if( $medication === null )
				 {
					 $medication = new Medication();
				 }

				 $form = $this->createForm( TherapeuticType::class, $medication );

				 $form->handleRequest($r);

				 if( $form->isSubmitted() && $form->isValid() )
				 {
					 $em = $this->getDoctrine()->getManager();

					 $em->persist($medication);

					 $em->flush();

					 $this->addFlash('success', 'Updated ' . $medication->getName());
				 }

				 return $this->render('Admin/manage.html.twig', array(
					 'form' => $form->createView(),
					 'route' => null,
				 ));
			 }
}
