<?php

namespace Sf2films\FilmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AddInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('year', 'text', array(
                    'label' => 'Год'
                ))
                ->add('duration', 'text', array(
                    'label' => 'Продолжиельность'
                ))
                ->add('budget', 'text', array(
                    'label' => 'Бюджет'
                ));
    }

    public function getName()
    {
        return 'addinfo';
    }
}