<?php

namespace Sf2films\FilmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

class FilmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('description', 'textarea')
                ->add('file', 'file')
                ->add('genres', 'entity', array(
                      'multiple' => true,
                      'class' => 'Sf2filmsFilmsBundle:Genre',
                      'query_builder' => function(EntityRepository $er) {
                          return $er->createQueryBuilder('genre')
                                    ->where('genre.is_publish = :is_publish')
                                    ->setParameter('is_publish', '1')
                                    ->orderBy('genre.name', 'ASC');
                      },
                      'property' => 'name'
                ))
                ->add('persons', 'entity', array(
                      'multiple' => true,
                      'class' => 'Sf2filmsFilmsBundle:Person',
                      'query_builder' => function(EntityRepository $er) {
                          return $er->createQueryBuilder('person')
                                    ->where('person.is_publish = :is_publish')
                                    ->setParameter('is_publish', '1')
                                    ->orderBy('person.name', 'ASC');
                      },
                      'property' => 'name'
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