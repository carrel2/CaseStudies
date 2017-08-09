<?php
// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
	private $tokenStorage;

	public function __construct(TokenStorageInterface $tokenStorage) {
		$this->tokenStorage = $tokenStorage;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType')
			->add('username', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
				'label' => 'Name',
			))
			->add('uin', 'Symfony\Component\Form\Extension\Core\Type\TextType')
			->add('plainPassword', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType', array(
				'type' => 'Symfony\Component\Form\Extension\Core\Type\PasswordType',
				'first_options'  => array(
					'label' => 'Password',
					'attr' => array(
						'class' => 'tooltip',
						'title' => 'Must be at least 6 characters long',
					),
				),
				'second_options' => array(
					'label' => 'Confirm Password',
				),
			));

		$builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
			$user = $event->getData();
			$form = $event->getForm();

			$currentUser = $this->tokenStorage->getToken()->getUser();

			if( $user && $user->getId() !== null ) {
				$config = $form->get('plainPassword')->getConfig();
				$options = $config->getOptions();

				$form->add('plainPassword', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', array(
					'label' => 'Password',
					'required' => !($currentUser->getRole() == 'ROLE_SUPER_ADMIN' && $user->getId() != $currentUser->getId()),
				));

				$form->add('newPassword', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType', array(
					'mapped' => false,
					'type' => 'Symfony\Component\Form\Extension\Core\Type\PasswordType',
					'required' => false,
					'first_options'  => array(
						'label' => 'New Password',
						'attr' => array(
							'class' => 'tooltip',
							'title' => 'Must be at least 6 characters long',
						),
					),
					'second_options' => array(
						'label' => 'Confirm New Password',
					),
				));

				$form->add('role', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
					'choices' => array(
						'User' => 'ROLE_USER',
						'Admin' => 'ROLE_ADMIN',
					),
					'choices_as_values' => true,
					'disabled' => $currentUser->getRole() == 'ROLE_USER',
				));
			}

			$form->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType');
		});
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User',
		));
	}
}
