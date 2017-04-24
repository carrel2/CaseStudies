<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Test;

class TestsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('test', EntityType::class, array(
				'class' => 'AppBundle:Test',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'choice_attr' => function(Test $t, $key, $index) {
					return ['class' => 'test'];
				}))
			->add('submit', SubmitType::class, array(
				'attr' => array('class' => 'button'),
			));
	}
}
