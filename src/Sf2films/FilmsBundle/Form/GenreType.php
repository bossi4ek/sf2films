<?php

namespace Sf2films\FilmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('is_publish', 'checkbox', array(
                    'required'  => false,
                ));
    }

    public function getName()
    {
        return 'genre';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Sf2films\FilmsBundle\Entity\Genre',
        );
    }
}