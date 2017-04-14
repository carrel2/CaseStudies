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

/**
 * UserType class
 *
 * @todo only show role on admin page
 */
class UserType extends AbstractType
{
	private $tokenStorage;

	public function __construct(TokenStorageInterface $tokenStorage) {
		$this->tokenStorage = $tokenStorage;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class)
			->add('username', TextType::class, array(
				'label' => 'Name',
			))
			->add('uin', TextType::class)
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options'  => array('label' => 'Password'),
				'second_options' => array('label' => 'Repeat Password'),
			));

		$builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
			$user = $event->getData();
			$form = $event->getForm();

			$currentUser = $this->tokenStorage->getToken()->getUser();

			if( $user && $user->getId() !== null ) {
				$config = $form->get('plainPassword')->getConfig();
				$options = $config->getOptions();

				$form->add('plainPassword', get_class($config->getType()->getInnerType()), array_replace(
					$options, ['required' => false,])
				);

				$form->add('role', ChoiceType::class, array(
					'choices' => array(
						'User' => 'ROLE_USER',
						'Admin' => 'ROLE_ADMIN',
					),
					'disabled' => $currentUser->getRole() == 'ROLE_USER',
				));

				$form->add('submit', SubmitType::class);
			}
		});
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => User::class,
		));
	}
}
