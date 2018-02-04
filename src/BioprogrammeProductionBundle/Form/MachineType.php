<?php

namespace BioprogrammeProductionBundle\Form;

use AppBundle\Form\Type\ImageType;
use BioprogrammeProductionBundle\Entity\Attribute;
use BioprogrammeProductionBundle\Entity\Category;
use BioprogrammeProductionBundle\Entity\Manufacturer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model')
            ->add('serialNumber')
//            ->add(
//                'categories',
//                EntityType::class,
//                [
//                    'class' => Category::class,
//                    'choice_label' => 'name',
//                    'placeholder' => 'Select',
//                    'attr' => [
//                        'class' => 'select2',
//                    ]
//                ]
//            )
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
            ->add('quantity')
            ->add('warranty')
            ->add('state')
            ->add('yearProduction')
            ->add(
                'dateDeployment',
                DateType::class,
                [
                    'widget' => 'single_text'
                ]
            )
            ->add('image', ImageType::class)
            ->add(
                'manufacturer',
                EntityType::class,
                [
                    'class' => Manufacturer::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select'
                ]
            )/*->add(
                'categories',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'attr' => [
                        'class' => 'select2',
                        'multiple' => 'multiple'
                    ]
                ]
            )
            ->add(
                'attributes',
                EntityType::class,
                [
                    'class' => Attribute::class,
                    'choice_label' => 'name',
                    'attr' => [
                        'class' => 'select2',
                        'multiple' => 'multiple'
                    ]
                ]
            )*/
            ->add('price')
            ->add('weight')
            ->add('length')
            ->add('width')
            ->add('height')
            ->add('sortOrder')
            ->add('isActive');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\Machine'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_machine';
    }


}
