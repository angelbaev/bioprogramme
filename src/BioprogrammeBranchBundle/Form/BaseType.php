<?php

namespace BioprogrammeBranchBundle\Form;

use BioprogrammeBranchBundle\Entity\Branch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('phone')
            ->add('image')
            ->add('isActive')
            ->add(
                'branch',
                EntityType::class,
                [
                    'class' => Branch::class,
                    'choice_label' => 'name'
                ]
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeBranchBundle\Entity\Base'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammebranchbundle_base';
    }


}
