<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\TherapeuticProcedure;

class TherapeuticsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$category = $options["category"];

		$builder
			->add('therapeuticProcedure', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:TherapeuticProcedure',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'label' => false,
				'query_builder' => function(EntityRepository $er) use ($category) {
					return $er->createQueryBuilder('t')
					  ->where('t.category = :c')
						->setParameter('c', $category);
				},
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

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'category' => 0,
		));
	}
}
