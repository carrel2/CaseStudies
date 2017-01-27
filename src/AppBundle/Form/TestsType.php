<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TestsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('test', EntityType::class, array(
				'class' => 'AppBundle:Test',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,)
			);
	}
}
