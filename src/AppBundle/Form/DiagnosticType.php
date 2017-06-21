<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Test;

class DiagnosticType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('name', TextType::class)
      ->add('cost', null, array(
        'attr' => array(
          'pattern' => '[0-9]+',
        )
      ))
      ->add('waitTime')
      ->add('group')
      ->add('submit', SubmitType::class, array(
        'attr' => array('class' => 'is-success'),
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => Test::class,
    ));
  }
}
