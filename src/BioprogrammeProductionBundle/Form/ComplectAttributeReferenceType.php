<?php

namespace BioprogrammeProductionBundle\Form;

use BioprogrammeProductionBundle\Entity\BuildingBlock;
use BioprogrammeProductionBundle\Entity\Complect;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComplectAttributeReferenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'complect',
                EntityType::class,
                [
                    'class' => Complect::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select',
                    'label' => false,
                    'attr' => [
                        'class' => 'hidden',
                    ]
                ]
            )
            ->add(
                'buildingBlock',
                EntityType::class,
                [
                    'class' => BuildingBlock::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select',
                    'attr' => [
                        'class' => 'select2',
                    ]
                ]
            )
            ->add('quantity');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\ComplectAttributeReference'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_complectattributereference';
    }


}
