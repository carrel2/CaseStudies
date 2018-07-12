<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiagnosticType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('diagnosticProcedure', 'AppBundle\Form\AbstractProcedureType', array(
        'label' => false,
        'data_class' => 'AppBundle\Entity\DiagnosticProcedure',
      ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\DiagnosticProcedure',
    ));
  }
}
