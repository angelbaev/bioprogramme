<?php

namespace BioprogrammeBranchBundle\Form;

use BioprogrammeBranchBundle\Entity\Building;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isActive')
            ->add(
                'building',
                EntityType::class,
                [
                    'class' => Building::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select',
                ]
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeBranchBundle\Entity\Line'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammebranchbundle_line';
    }


}
