<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbstractProcedureType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('name', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
      'label_attr' => array(
        'class' => 'is-large asterisk',
      ),
    ))
      ->add('groupName', null, array(
        'required' => false,
        'empty_data' => null,
        'label_attr' => array(
          'class' => 'is-large',
        ),
      ))
      ->add('dosage', null, array(
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('dosageInterval', null, array(
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('concentration', null, array(
        'label_attr' => array(
          'class' => 'is-large asterisk',
        ),
      ))
      ->add('costPerUnit', null, array(
        'required' => false,
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
      ->add('defaultResult', null, array(
        'required' => false,
        'label_attr' => array(
          'class' => 'is-large',
        ),
      ))
      ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
        'attr' => array(
          'class' => 'is-success',
          'style' => 'margin-top: 1rem;',
        ),
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'inherit_data' => true,
    ));
  }
}