<?php

namespace BioprogrammeProductionBundle\Form;

use AppBundle\Form\Type\ImageType;
use BioprogrammeProductionBundle\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add(
                'warranty',
                ChoiceType::class,
                [
                    'choices' => [
                        '1 месец' => '1 месец',
                        '2 месецa' => '2 месецa',
                        '3 месецa' => '3 месецa',
                        '4 месецa' => '4 месецa',
                        '5 месецa' => '5 месецa',
                        '6 месецa' => '6 месецa',
                        '7 месецa' => '7 месецa',
                        '8 месецa' => '8 месецa',
                        '9 месецa' => '9 месецa',
                        '10 месецa' => '10 месецa',
                        '11 месецa' => '11 месецa',
                        '12 месецa' => '12 месецa',
                        '13 месецa' => '13 месецa',
                        '14 месецa' => '14 месецa',
                        '15 месецa' => '15 месецa',
                        '16 месецa' => '16 месецa',
                        '17 месецa' => '17 месецa',
                        '18 месецa' => '18 месецa',
                        '19 месецa' => '19 месецa',
                        '20 месецa' => '20 месецa',
                        '21 месецa' => '21 месецa',
                        '22 месецa' => '22 месецa',
                        '23 месецa' => '23 месецa',
                        '24 месецa' => '24 месецa',
                        '25 месецa' => '25 месецa',
                        '26 месецa' => '26 месецa',
                        '27 месецa' => '27 месецa',
                        '28 месецa' => '28 месецa',
                        '29 месецa' => '29 месецa',
                        '30 месецa' => '30 месецa',
                        '31 месецa' => '31 месецa',
                        '32 месецa' => '32 месецa',
                        '33 месецa' => '33 месецa',
                        '34 месецa' => '34 месецa',
                        '35 месецa' => '35 месецa',
                        '36 месецa' => '36 месецa',
                        '37 месецa' => '37 месецa',
                        '38 месецa' => '38 месецa',
                        '39 месецa' => '39 месецa',
                        '40 месецa' => '40 месецa',
                        '41 месецa' => '41 месецa',
                        '42 месецa' => '42 месецa',
                        '43 месецa' => '43 месецa',
                        '44 месецa' => '44 месецa',
                        '45 месецa' => '45 месецa',
                        '46 месецa' => '46 месецa',
                        '47 месецa' => '47 месецa',
                        '48 месецa' => '48 месецa',
                        '49 месецa' => '49 месецa',
                        '50 месецa' => '50 месецa',
                        '51 месецa' => '51 месецa',
                        '52 месецa' => '52 месецa',
                        '53 месецa' => '53 месецa',
                        '54 месецa' => '54 месецa',
                        '55 месецa' => '55 месецa',
                        '56 месецa' => '56 месецa',
                        '57 месецa' => '57 месецa',
                        '58 месецa' => '58 месецa',
                        '59 месецa' => '59 месецa',
                        '60 месецa' => '60 месецa',
                    ]
                ]
            )
            ->add(
                'state',
                ChoiceType::class,
                [
                    'choices' => [
                        'Работи' => '1',
                        'Не работи' => '2',
                        'В ремонт' => '3'
                    ]
                ]
            )
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
