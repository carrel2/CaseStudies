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
			->add('users', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:User',
				'choice_label' => 'username',
				'expanded' => true,
			))
			->add('edit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array('class' => 'is-success'),
			))
			->add('delete', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'attr' => array('class' => 'is-danger'),
			));
	}
}
