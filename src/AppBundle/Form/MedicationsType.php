<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Medication;

class MedicationsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('medication', EntityType::class, array(
				'class' => 'AppBundle:Medication',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'choice_attr' => function(Medication $t, $key, $index) {
					return ['class' => 'medication'];
				}))
			->add('submit', SubmitType::class, array(
				'attr' => array('class' => 'button'),
			));
	}
}
