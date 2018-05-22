<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Test;

class DiagnosticsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$caseStudy = $options['cs'];

		$builder
			->add('test', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:Test',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'label' => false,
				'choice_attr' => function(Test $t, $key, $index) use ($caseStudy) {
					$r = $t->getResultsByCase($caseStudy);

					return ['class' => 'test', 'data-cost' => $r ? $r->getCost() : $t->getCostPerUnit(), 'data-use-weight' => (int) !((bool) $r)];
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

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults(array(
				'cs' => null,
			));
	}
}
