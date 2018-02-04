<?php

namespace BioprogrammeProductionBundle\Form;

use BioprogrammeProductionBundle\Entity\Machine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineManualType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add(
                'manual',
                TextareaType::class,
                [
                    'label' => FALSE,
                    'attr' => [
                        'class' => 'wysihtml',
                        'style' => 'height: 600px;'
                    ]
                ]
            )
            ->add(
                'machine',
                EntityType::class,
                [
                    'class' => Machine::class,
                    'label' => FALSE,
                    'choice_label'=> 'name',
                    'attr' => [
                        'class' => 'hidden'
                    ]
                ]
            )
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\MachineManual'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_machinemanual';
    }


}
