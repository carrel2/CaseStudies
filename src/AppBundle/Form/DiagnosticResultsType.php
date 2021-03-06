<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\DiagnosticResults;

class DiagnosticResultsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('diagnosticProcedure', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:DiagnosticProcedure',
				'choice_label' => 'name',
				'query_builder' => function (EntityRepository $er) {
        	return $er->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC');
    		},
				'label' => false,
			))
			->add('results', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
				'label_attr' => array(
					'id' => 'day_Z_diagnostic_results_Z_label',
					'class' => 'is-large asterisk',
				),
				'config' => array(
					'autoParagraph' => false,
				)
			))
			->add('waitTime', null, array(
				'label_attr' => array(
					'id' => 'day_Z_diagnostic_wait_time_Z_label',
					'class' => 'is-large',
				),
			))
			->add('cost', null, array(
				'required' => false,
				'label_attr' => array(
					'id' => 'day_Z_diagnostic_cost_Z_label',
					'class' => 'is-large',
				)
			));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\DiagnosticResults',
			'label' => false,
		));
	}
}
