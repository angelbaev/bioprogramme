<?php

namespace BioprogrammeProductionBundle\Form;

use AppBundle\Form\Type\ImageType;
use BioprogrammeProductionBundle\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComplectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('name')
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
            ->add('price')
            ->add('quantity')
            ->add('warranty')
            ->add('state')
            ->add(
                'dateOfManufacture',
                DateType::class,
                [
                    'widget' => 'single_text'
                ]
            )
            ->add(
                'dateImplementation',
                DateType::class,
                [
                    'widget' => 'single_text'
                ]
            )
            ->add(
                'manufacturer',
                EntityType::class,
                [
                    'class' => Manufacturer::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select'
                ]
            );
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
        return 'bioprogrammeproductionbundle_complect';
    }


}
