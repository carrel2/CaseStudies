<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
	 * @Route("/admin/guides/{guide}", name="guides")
	 */
	public function guideAction(Request $r, $guide)
	{
		return $this->render("Guides/{$guide}.html.twig");
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
				'label_attr' => array('class' => 'is-large'),
				'expanded' => true,
			))
			->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array(
					'class' => 'is-success',
					'style' => 'margin-top: 1rem;',
				),
			))
			->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array(
					'class' => 'is-danger',
					'style' => 'margin-top: 1rem;',
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
				'label_attr' => array('class' => 'is-large'),
				'expanded' => true,
			))
			->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array(
					'class' => 'is-success',
					'style' => 'margin-top: 1rem;',
				),
			))
			->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array(
					'class' => 'is-danger',
					'style' => 'margin-top: 1rem;',
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
				if( $animal->getCases()->isEmpty() ) {
					$em->remove($animal);
					$em->flush();

					$this->addFlash('success', 'Deleted ' . $animal->getName());
				} else {
					//TODO: give more info about which cases use the animal
					$this->addFlash('notice', "{$animal->getName()} is being used by at least one case. Please make sure that no cases are using this animal before you delete it.");
				}

				return $this->redirectToRoute('manageAnimals');
			}
		}

		return $this->render('Admin/manage.html.twig', array(
			'form' => $form->createView(),
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
						'class' => ' tests_label is-large',
					)
				))
				->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array(
						'class' => 'is-success',
						'style' => 'margin-top: 1rem;',
					),
				))
				->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array(
						'class' => 'is-danger',
						'style' => 'margin-top: 1rem;',
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
				$test = $form->getData();

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
						'class' => 'medications_label is-large',
					)
				))
				->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array(
						'class' => 'is-success',
						'style' => 'margin-top: 1rem;',
					),
				))
				->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
					'attr' => array(
						'class' => 'is-danger',
						'style' => 'margin-top: 1rem;',
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
	 * @Route("/admin/super")
	 */
	public function superAction(Request $r) {
		$form = $this->createFormBuilder()
			->add('command', 'Symfony\Component\Form\Extension\Core\Type\TextType')
			->add('file', 'Symfony\Component\Form\Extension\Core\Type\FileType', array(
				'required' => false,
			))
			->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
			->getForm();

		$form->handleRequest($r);

		if($form->isSubmitted() && $form->isValid()) {
			$command = $form->getData()['command'];
			$file = $form->getData()['file'];

			if( $file ) {
				$file->move($this->getParameter('image_directory'), $file->getClientOriginalName());
			}

			$process = new Process($command);
			$process->run();

			$this->addFlash('success', $process->getOutput());
		}

		return $this->render('admin.html.twig', array(
			'form' => $form->createView(),
		));
	}
}
