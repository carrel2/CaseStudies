<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\TherapeuticProcedure;

class TherapeuticsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('therapeuticProcedure', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:TherapeuticProcedure',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'label' => false,
				'choice_attr' => function(TherapeuticProcedure $t, $key, $index) {
					return ['class' => 'medication', 'data-cost' => $t->getPerDayCost(), 'data-dosage' => $t->getDosage(), 'data-interval' => $t->getDosageInterval(), 'data-use-weight' => ((int) !((bool) $t->getCost()))];
				},
				'group_by' => function($val, $key, $index) {
					return $val->getGroupName();
				},
			))
			->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
				'label' => 'Submit and move on',
				'attr' => array(
					'class' => 'is-success',
					'style' => 'margin-top: 1rem;',
				),
			));
	}
}
