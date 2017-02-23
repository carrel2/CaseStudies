<?php
// src/AppBundle\Form\DefaultType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\CaseStudy;

/*
@TODO

replace code in controller with form event pre_set_data to dynamically modify form
*/

class DefaultType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title', EntityType::class, array(
				'class' => 'AppBundle:CaseStudy',
				'choice_label' => 'title',
				'attr' => array(
					'onchange' => 'updateCase',)))
			->add('start', SubmitType::class);
	}
}
