<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\MedicationResults;

class TherapeuticResultsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('medication', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:Medication',
				'choice_label' => 'name',
				'query_builder' => function (EntityRepository $er) {
        	return $er->createQueryBuilder('m')
            ->orderBy('m.name', 'ASC');
    		},
				'label' => false,
			))
			->add('results', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
				'label_attr' => array(
					'class' => 'is-large',
				),
				'config' => array(
					'autoParagraph' => false,
				)
			))
			->add('waitTime', null, array(
				'label_attr' => array(
					'class' => 'is-large',
				),
			))
			->add('cost', null, array(
				'label_attr' => array(
					'class' => 'is-large',
				)
			));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\MedicationResults',
			'label' => false,));
	}
}
