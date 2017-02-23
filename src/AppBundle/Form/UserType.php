<?php
// src/AppBundle/Form/UserType.php
namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class)
			->add('username', TextType::class)
			->add('uin', TextType::class)
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options'  => array('label' => 'Password'),
				'second_options' => array('label' => 'Repeat Password'),));

		$builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
			$user = $event->getData();
			$form = $event->getForm();

			if( $user && $user->getId() !== null ) {
				$config = $form->get('plainPassword')->getConfig();
				$options = $config->getOptions();

				$form->add('plainPassword', get_class($config->getType()->getInnerType()), array_replace(
					$options, ['required' => false,])
				);

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
