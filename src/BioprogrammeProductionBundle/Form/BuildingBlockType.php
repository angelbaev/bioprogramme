<?php

namespace BioprogrammeProductionBundle\Form;

use AppBundle\Form\Type\ImageType;
use BioprogrammeProductionBundle\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingBlockType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('model')
            ->add(
                'description',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'wysihtml',
                    ]
                ]
            )
            ->add('image', ImageType::class)
            ->add('quantity')
            ->add('warranty')
            ->add('weight')
            ->add('length')
            ->add('height')
            ->add('isActive')
            ->add(
                'manufacturer',
                EntityType::class,
                [
                    'class' => Manufacturer::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select'
                ]
            );
            //->add('complects');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\BuildingBlock'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_buildingblock';
    }


}
