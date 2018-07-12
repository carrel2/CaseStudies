<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\TherapeuticProcedure;

class TherapeuticsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$caseStudy = $options['cs'];

		$builder
			->add('medication', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:TherapeuticProcedure',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'label' => false,
				'choice_attr' => function(TherapeuticProcedure $t, $key, $index) use ($caseStudy) {
					$r = $t->getResultsByCase($caseStudy);

					return ['class' => 'medication', 'data-cost' => $r ? $r->getCost() : $t->getPerDayCost(), 'data-use-weight' => (int) !((bool) $r)];
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

	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults(array(
				'cs' => null,
			));
	}
}
