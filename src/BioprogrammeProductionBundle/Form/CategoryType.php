<?php

namespace BioprogrammeProductionBundle\Form;

use AppBundle\Form\Type\ImageType;
use BioprogrammeProductionBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('image', ImageType::class)
            ->add('sortOrder')
            ->add('isActive')
            ->add('parent',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select',
                ]
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_category';
    }


}
