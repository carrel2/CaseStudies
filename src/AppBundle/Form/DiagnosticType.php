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
    $builder->add('name', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
      'label_attr' => array(
        'class' => 'is-large',
      ),
    ))
      ->add('costPerUnit', null, array(
        'attr' => array(
          'pattern' => '[0-9]+(\.[0-9]{1,2})?',
        ),
        'label_attr' => array(
          'class' => 'is-large',
        ),
      ))
      ->add('waitTime', null, array(
        'required' => false,
        'empty_data' => 0,
        'label_attr' => array(
          'class' => 'is-large',
        ),
      ))
      ->add('group', null, array(
        'required' => false,
        'empty_data' => null,
        'label_attr' => array(
          'class' => 'is-large',
        ),
      ))
      ->add('defaultResult', null, array(
        'required' => false,
        'label_attr' => array(
          'class' => 'is-large',
        ),
      ))
      ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
        'attr' => array('class' => 'is-success'),
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Test',
    ));
  }
}
