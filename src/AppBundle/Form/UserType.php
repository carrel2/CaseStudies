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
		$currentUser = $this->tokenStorage->getToken()->getUser();

		$builder->add('role', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
					'choices' => array(
						'User' => 'ROLE_USER',
						'Admin' => 'ROLE_ADMIN',
					),
					'choices_as_values' => true,
					'disabled' => $currentUser->getRole() == 'ROLE_USER',
				))
				->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType');
		});
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\User',
		));
	}
}
