<?php

namespace Sf2films\FilmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FilmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('description', 'textarea')
                ->add('genres', 'entity', array(
                    'multiple' => true,
                    'class' => 'Sf2filmsFilmsBundle:Genre',
                    'property' => 'name',
                ))
                ->add('persons', 'entity', array(
                    'multiple' => true,
                    'class' => 'Sf2filmsFilmsBundle:Person',
                    'property' => 'name',
                ))
                ->add('is_publish', 'checkbox', array(
                    'required'  => false,
                ));
    }

    public function getName()
    {
        return 'films';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Sf2films\FilmsBundle\Entity\Content',
        );
    }
}