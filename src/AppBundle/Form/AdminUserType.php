<?php
// src/AppBundle/Form/AdminUserType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\User;

class AdminUserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('users', EntityType::class, array(
				'class' => 'AppBundle:User',
				'choice_label' => 'username',
				'expanded' => true,
				'attr' => array(
					'class' => 'select',
				)
			))
			->add('edit', SubmitType::class, array(
				'attr' => array('class' => 'button'),
			))
			->add('delete', SubmitType::class, array(
				'attr' => array('class' => 'button'),
			));
	}
}
