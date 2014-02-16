<?php

namespace Sf2films\CommentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('txt', 'textarea', array('label' => 'comments_form.comments_txt'));
    }

    public function getName()
    {
        return 'comment';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        return array(
            'data_class' => 'Sf2films\CommentBundle\Entity\Comment',
        );
    }
}