<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\TestResults;

class DiagnosticResultsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('test', EntityType::class, array(
				'class' => 'AppBundle:Test',
				'choice_label' => 'name',
				'group_by' => function($val, $key, $index) {
					return $val->getGroup();
				},
				'label' => false,
			))
			->add('results', CKEditorType::class);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => TestResults::class,
			'label' => false,
		));
	}
}
