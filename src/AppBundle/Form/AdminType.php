<?php
// src/AppBundle\Form\AdminType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\CaseStudy;

class AdminType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('case', EntityType::class, array(
				'class' => 'AppBundle:CaseStudy',
				'choice_label' => 'title',));
	}
}
