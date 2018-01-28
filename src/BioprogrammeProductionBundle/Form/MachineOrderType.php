<?php

namespace BioprogrammeProductionBundle\Form;

use BioprogrammeBranchBundle\Entity\Base;
use BioprogrammeProductionBundle\Entity\MachineOrderReference;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serialNumber')
            ->add(
                'base',
                EntityType::class,
                [
                    'class' => Base::class,
                    'choice_label' => 'name'
                ]
            )
        ->add(
            'machineOrderReferences',
                EntityType::class,
                [
                    'class' => MachineOrderReference::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'attr' => [
                        'class' => 'select2',
                        'multiple' => 'multiple'
                    ]
                ]
        );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\MachineOrder'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_machineorder';
    }


}
