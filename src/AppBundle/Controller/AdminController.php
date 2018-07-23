<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\User;
use AppBundle\Entity\Animal;
use AppBundle\Entity\DiagnosticProcedure;
use AppBundle\Entity\TherapeuticProcedure;

class AdminController extends Controller
{
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
	  * @Route("/admin/diagnostics", name="manageDiagnostics")
		*/
		public function testsAction(Request $r)
		{
			$em = $this->getDoctrine()->getManager();

			$form = $this->createFormBuilder()
				->add('diagnosticProcedures', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
					'class' => 'AppBundle:DiagnosticProcedure',
					'choice_label' => 'name',
					'expanded' => true,
					'choice_attr' => function(DiagnosticProcedure $d, $key, $index) {
						return ['class' => 'diagnosticProcedure'];
					},
					'group_by' => function($val, $key, $index) {
						return $val->getGroupName();
					},
					'label_attr' => array(
						'class' => ' diagnostics_label is-large',
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
				$diagnosticProcedure = $form->getData()['diagnosticProcedures'];

				if( $form->get('edit')->isClicked() ) {
					return $this->redirectToRoute('editDiagnosticProcedure', array('id' => $diagnosticProcedure->getId()));
				} else if( $form->get('delete')->isClicked() ) {
					$em->remove($diagnosticProcedure);
					$em->flush();

					$this->addFlash('success', 'Deleted ' . $diagnosticProcedure->getName());

					return $this->redirectToRoute('manageDiagnostics');
				}
			}

			return $this->render('Admin/manage.html.twig', array(
				'form' => $form->createView(),
				'route' => 'createDiagnosticProcedure',
			));
		}

		/**
		 * @Route("/admin/create/diagnostic-procedure", name="createDiagnosticProcedure")
		 */
		public function createDiagnosticAction(Request $r)
		{
			$form = $this->createForm( 'AppBundle\Form\DiagnosticType' );

			$form->handleRequest($r);

			if( $form->isSubmitted() && $form->isValid() )
			{
				$em = $this->getDoctrine()->getManager();
				$diagnosticProcedure = $form->getData();

				$em->persist($diagnosticProcedure);

				$em->flush();

				$this->addFlash('success', 'Created ' . $diagnosticProcedure->getName());

				return $this->redirectToRoute('manageDiagnostics');
			}

			return $this->render('Admin/manage.html.twig', array(
				'form' => $form->createView(),
				'route' => null,
			));
		}

		/**
		 * @Route("/admin/edit/diagnostics/{id}", name="editDiagnosticProcedure")
		 */
		 public function editDiagnosticAction(Request $r, DiagnosticProcedure $dp = null)
		 {
			 if( $dp === null )
			 {
				 $dp = new DiagnosticProcedure();
			 }

			 $form = $this->createForm( 'AppBundle\Form\DiagnosticType', $dp );

			 $form->handleRequest($r);

			 if( $form->isSubmitted() && $form->isValid() )
			 {
				 $em = $this->getDoctrine()->getManager();

				 $em->persist($dp);

				 $em->flush();

				 $this->addFlash('success', 'Updated ' . $dp->getName());
			 }

			 return $this->render('Admin/manage.html.twig', array(
				 'form' => $form->createView(),
				 'route' => null,
			 ));
		 }

		/**
		 * @Route("/admin/therapeutics", name="manageTherapeutics")
		 */
		public function medicationsAction(Request $r)
		{
			$em = $this->getDoctrine()->getManager();

			$form = $this->createFormBuilder()
				->add('therapeuticProcedures', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
					'class' => 'AppBundle:TherapeuticProcedure',
					'choice_label' => 'name',
					'expanded' => true,
					'choice_attr' => function(TherapeuticProcedure $t, $key, $index) {
						return ['class' => 'therapeuticProcedure'];
					},
					'group_by' => function($val, $key, $index) {
						return $val->getGroupName();
					},
					'label_attr' => array(
						'class' => 'therapeutics_label is-large',
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
				$therapeuticProcedure = $form->getData()['therapeuticProcedures'];

				if( $form->get('edit')->isClicked() ) {
					return $this->redirectToRoute('editTherapeuticProcedure', array('id' => $therapeuticProcedure->getId()));
				} else if( $form->get('delete')->isClicked() ) {
					$em->remove($therapeuticProcedure);
					$em->flush();

					$this->addFlash('success', 'Deleted ' . $therapeuticProcedure->getName());

					return $this->redirectToRoute('manageTherapeutics');
				}
			}

			return $this->render('Admin/manage.html.twig', array(
				'form' => $form->createView(),
				'route' => 'createTherapeuticProcedure',
			));
		}

			/**
			 * @Route("/admin/create/therapeutic-procedure", name="createTherapeuticProcedure")
			 */
			public function createTherapeuticAction(Request $r)
			{
				$form = $this->createForm( 'AppBundle\Form\TherapeuticType' );

				$form->handleRequest($r);

				if( $form->isSubmitted() && $form->isValid() )
				{
					$em = $this->getDoctrine()->getManager();
					$therapeuticProcedure = $form->getData();

					$em->persist($therapeuticProcedure);

					$em->flush();

					$this->addFlash('success', 'Created ', $therapeuticProcedure->getName());

					return $this->redirectToRoute('manageTherapeutics');
				}

				return $this->render('Admin/manage.html.twig', array(
					'form' => $form->createView(),
					'route' => null,
				));
			}

			/**
			 * @Route("/admin/edit/medications/{id}", name="editTherapeuticProcedure")
			 */
			 public function editTherapeuticAction(Request $r, TherapeuticProcedure $tp = null)
			 {
				 if( $tp === null )
				 {
					 $tp = new TherapeuticProcedure();
				 }

				 $form = $this->createForm( 'AppBundle\Form\TherapeuticType', $tp );

				 $form->handleRequest($r);

				 if( $form->isSubmitted() && $form->isValid() )
				 {
					 $em = $this->getDoctrine()->getManager();

					 $em->persist($tp);

					 $em->flush();

					 $this->addFlash('success', 'Updated ' . $tp->getName());
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
