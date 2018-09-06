<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\TherapeuticResults;

class TherapeuticResultsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('therapeuticProcedure', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:TherapeuticProcedure',
				'choice_label' => 'name',
				'query_builder' => function (EntityRepository $er) {
        	return $er->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    		},
				'label' => false,
			))
			->add('results', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
				'label_attr' => array(
					'id' => 'day_Z_therapeutic_results_Z_label',
					'class' => 'is-large asterisk',
				),
				'config' => array(
					'autoParagraph' => false,
				)
			))
			->add('waitTime', null, array(
				'label_attr' => array(
					'id' => 'day_Z_therapeutic_wait_time_Z_label',
					'class' => 'is-large',
				),
			))
			->add('cost', null, array(
				'required' => false,
				'label_attr' => array(
					'id' => 'day_Z_therapeutic_cost_Z_label',
					'class' => 'is-large',
				)
			));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\TherapeuticResults',
			'label' => false,));
	}
}
