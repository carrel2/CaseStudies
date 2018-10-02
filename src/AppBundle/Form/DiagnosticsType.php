<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\DiagnosticProcedure;

class DiagnosticsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$category = $options["category"];

		$builder
			->add('diagnosticProcedure', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:DiagnosticProcedure',
				'choice_label' => 'name',
				'expanded' => true,
				'multiple' => true,
				'label' => false,
				'query_builder' => function(EntityRepository $er) use ($category) {
					return $er->createQueryBuilder('d')
					  ->where('d.category = :c')
						->setParameter('c', $category);
				},
				'choice_attr' => function(DiagnosticProcedure $d, $key, $index) {
					return ['class' => 'test', 'data-cost' => $d->getCost()];
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
