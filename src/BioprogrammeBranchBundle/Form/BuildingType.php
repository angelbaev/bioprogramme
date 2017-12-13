<?php

namespace BioprogrammeBranchBundle\Form;

use BioprogrammeBranchBundle\Entity\Base;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingType extends AbstractType
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
                'base',
                EntityType::class,
                [
                    'class' => Base::class,
                    'choice_label' => 'name'
                ]
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeBranchBundle\Entity\Building'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammebranchbundle_building';
    }


}
