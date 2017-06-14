<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\MedicationResults;

class TherapeuticResultsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('medication', EntityType::class, array(
				'class' => 'AppBundle:Medication',
				'choice_label' => 'name',
				'attr' => array(
					'class' => 'select',
				)
				'group_by' => function($val, $key, $index) {
					return $val->getGroup();
				},
				'label' => false,
			))
			->add('results', CKEditorType::class, array(
				'config' => array(
					'autoParagraph' => false,
				)
			))
			->add('waitTime', null, array(
				'attr' => array(
					'class' => 'input',
				)
			));
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => MedicationResults::class,
			'label' => false,));
	}
}
