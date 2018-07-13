<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\DiagnosticProcedure;

class DiagnosticsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('test', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:DiagnosticProcedure',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'label' => false,
				'choice_attr' => function(DiagnosticProcedure $d, $key, $index) {
					return ['class' => 'test', 'data-cost' => $d->getPerDayCost(), 'data-dosage' => $d->getDosage(), 'data-interval' => $d->getDosageInterval()];
				},
				'group_by' => function($val, $key, $index) {
					return $val->getGroup();
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
