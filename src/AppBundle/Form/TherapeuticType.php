<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Medication;

class TherapeuticType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('name', TextType::class, array(
        'attr' => array(
          'class' => 'input',
        )
      ))
      ->add('cost', null, array(
        'attr' => array(
          'pattern' => '[0-9]+',
          'class' => 'input',
        )
      ))
      ->add('waitTime', null, array(
        'attr' => array(
          'class' => 'input',
        )
      ))
      ->add('group', null, array(
        'attr' => array(
          'class' => 'input',
        )
      ))
      ->add('submit', SubmitType::class, array(
        'attr' => array('class' => 'button'),
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => Medication::class,
    ));
  }
}
