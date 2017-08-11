<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Process\Process;
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

class AdminController extends Controller
{
	/**
	 * @Route("/admin", name="admin")
	 */
	public function adminAction(Request $r)
	{
		return $this->render('admin.html.twig', array(
			'form' => null,
		));
	}

	/**
	 * @Route("/admin/edit/case", name="editCase")
	 */
	public function editCaseAction(Request $r)
	{
		$form = $this->createForm( 'AppBundle\Form\AdminType' );

		$form->handleRequest($r);

		return $this->render('Admin/editCase.html.twig', array(
			'form' => $form->createView(),
		));
	}

	/**
	 * @Route("/admin/create/case", name="createCase")
	 */
	public function createCaseAction(Request $r)
	{
		$form = $this->createForm( 'AppBundle\Form\CaseType' );

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
	 * @Route("/admin/getCase/{id}", name="caseInfo")
	 */
	public function getCaseAction(Request $r, CaseStudy $case)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm( 'AppBundle\Form\CaseType', $case );

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
	 * @Route("/admin/users", name="manageUsers")
	 */
	public function manageUsersAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createFormBuilder()->add('users', 'Symfony\Bridge\Doctrine\Form\Type\EntityType',
			array(
				'class' => 'AppBundle:User',
				'choice_label' => 'username',
				'expanded' => true,
			))
			->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array('class' => 'is-success'),
			))
			->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
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
	 * @Route("/admin/edit/users/{id}", name="editUser")
	 */
	public function editUserAction(Request $r, User $user)
	{
		$form = $this->createForm( 'AppBundle\Form\UserType', $user );

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
	 * @Route("/admin/animals", name="manageAnimals")
	 */
	public function animalAction(Request $r)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createFormBuilder()
			->add('animals', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:Animal',
				'choice_label' => 'name',
				'expanded' => true,
			))
			->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array('class' => 'is-success'),
			))
			->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
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
	 * @Route("/admin/create/animal", name="createAnimal")
	 */
	public function createAnimalAction(Request $r)
	{
		$form = $this->createForm( 'AppBundle\Form\AnimalType' );

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
	 * @Route("/admin/edit/animals/{id}", name="editAnimal")
	 */
	 public function hotspotsAction(Request $r, Animal $animal = null)
	 {
		 if( $animal === null )
		 {
			 $animal = new Animal();
		 }

		 $form = $this->createForm( 'AppBundle\Form\AnimalType', $animal );

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
			 'size' => getimagesize("./images/{$animal->getImage()}"),
			 'route' => null,
		 ));
	 }

	 /**
	  * @Route("/admin/tests", name="manageTests")
		*/
		public function testsAction(Request $r)
		{
			$em = $this->getDoctrine()->getManager();

			$form = $this->createFormBuilder()
				->add('tests', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
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
				->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array('class' => 'is-success'),
				))
				->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
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
		 * @Route("/admin/create/test", name="createTest")
		 */
		public function createTestAction(Request $r)
		{
			$form = $this->createForm( 'AppBundle\Form\DiagnosticType' );

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
		 * @Route("/admin/edit/tests/{id}", name="editTest")
		 */
		 public function editTestAction(Request $r, Test $test = null)
		 {
			 if( $test === null )
			 {
				 $test = new Test();
			 }

			 $form = $this->createForm( 'AppBundle\Form\DiagnosticType', $test );

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
		 * @Route("/admin/medications", name="manageMedications")
		 */
		public function medicationsAction(Request $r)
		{
			$em = $this->getDoctrine()->getManager();

			$form = $this->createFormBuilder()
				->add('medications', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
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
				->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array('class' => 'is-success'),
				))
				->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
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
			 * @Route("/admin/create/medication", name="createMedication")
			 */
			public function createMedicationAction(Request $r)
			{
				$form = $this->createForm( 'AppBundle\Form\TherapeuticType' );

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
			 * @Route("/admin/edit/medications/{id}", name="editMedication")
			 */
			 public function editMedicationAction(Request $r, Medication $medication = null)
			 {
				 if( $medication === null )
				 {
					 $medication = new Medication();
				 }

				 $form = $this->createForm( 'AppBundle\Form\TherapeuticType', $medication );

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

	// TODO: Remove for production
	/**
	 * @Route("/admin/clear/cache/{env}")
	 */
	public function cacheAction($env="dev") {
		$process = new Process("php /var/www/project/bin/console cache:clear --env={$env}");
		$process->run();

		return new Response($process->getOutput());
	}
}
