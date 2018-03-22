<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\TestResults;

class DiagnosticResultsType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('test', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
				'class' => 'AppBundle:Test',
				'choice_label' => 'name',
				/*'group_by' => function($val, $key, $index) {
					return $val->getGroup();
				},*/
				'label' => false,
			))
			->add('results', 'Ivory\CKEditorBundle\Form\Type\CKEditorType', array(
				'config' => array(
					'autoParagraph' => false,
				)
			))
			->add('waitTime');
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\TestResults',
			'label' => false,
		));
	}
}
