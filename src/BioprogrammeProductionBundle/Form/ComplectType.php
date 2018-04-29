<?php

namespace BioprogrammeProductionBundle\Form;

use AppBundle\Form\Type\ImageType;
use BioprogrammeProductionBundle\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                    'required' => false,
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
                TextType::class,
                [
                    'required' => false,
                    'attr' => [
                        'class' => 'range-datepicker'
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
                    'required' => false,
                    'widget' => 'single_text'
                ]
            )
            ->add(
                'dateImplementation',
                DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text'
                ]
            )
            ->add('weight')
            ->add(
                'weightVal',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        'грам(г, g)' => 'грам(г, g)',
                        'килограм(кг, kg)' => 'килограм(кг, kg)',
                        'тон(т, t)' => 'тон(т, t)',
                    ],
                    'placeholder' => 'Select',
                    'label' => false
                ]
            )
            ->add('length')
            ->add(
                'lengthVal',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        'милиметър(мм, mm)' => 'милиметър(мм, mm)',
                        'сантиметър(см, cm)' => 'сантиметър(см, cm)',
                        'метър(м, m)' => 'метър(м, m)',
                        'инч(in)' => 'инч(in)',
                        'фут(ft)' => 'фут(ft)',
                    ],
                    'placeholder' => 'Select',
                    'label' => false
                ]
            )
            ->add('width')
            ->add(
                'widthVal',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        'милиметър(мм, mm)' => 'милиметър(мм, mm)',
                        'сантиметър(см, cm)' => 'сантиметър(см, cm)',
                        'метър(м, m)' => 'метър(м, m)',
                        'инч(in)' => 'инч(in)',
                        'фут(ft)' => 'фут(ft)',
                    ],
                    'placeholder' => 'Select',
                    'label' => false
                ]
            )
            ->add('height')
            ->add(
                'heightVal',
                ChoiceType::class,
                [
                    'required' => false,
                    'choices' => [
                        'милиметър(мм, mm)' => 'милиметър(мм, mm)',
                        'сантиметър(см, cm)' => 'сантиметър(см, cm)',
                        'метър(м, m)' => 'метър(м, m)',
                        'инч(in)' => 'инч(in)',
                        'фут(ft)' => 'фут(ft)',
                    ],
                    'placeholder' => 'Select',
                    'label' => false
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
