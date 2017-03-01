<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MedicationsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('medication', EntityType::class, array(
				'class' => 'AppBundle:Medication',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,))
			->add('submit', SubmitType::class);
	}
}
