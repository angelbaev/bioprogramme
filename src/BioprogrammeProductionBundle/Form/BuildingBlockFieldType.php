<?php

namespace BioprogrammeProductionBundle\Form;


use BioprogrammeProductionBundle\Entity\BuildingBlock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingBlockFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'buildingBlocks',
                EntityType::class,
                [
                    'class' => BuildingBlock::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select',
                    'label' => 'Building Blocks',
                    'attr' => [
                        'class' => 'building-block select2'
                    ]
                ]
            );
            //->add('complects');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\Complect'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_buildingblock_field';
    }


}
