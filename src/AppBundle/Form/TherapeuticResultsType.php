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
				'label' => false,
			))
			->add('results', CKEditorType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => MedicationResults::class,
			'label' => false,));
	}
}
