<?php

namespace Sf2films\FilmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('date_birth', 'date', array(
                    'input'  => 'timestamp',
                    'widget' => 'choice',
                ))
                ->add('gender_code', 'gender', array(
                    'empty_value' => 'Выберите пол',
                ))
                ->add('is_publish', 'checkbox', array(
                    'required'  => false,
                ));
    }

    public function getName()
    {
        return 'person';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return array(
            'data_class' => 'Sf2films\FilmsBundle\Entity\Person',
        );
    }
}