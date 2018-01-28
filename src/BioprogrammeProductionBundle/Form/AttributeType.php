<?php

namespace BioprogrammeProductionBundle\Form;

use BioprogrammeProductionBundle\Entity\AttributeGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('sortOrder')
            ->add(
                'attributeGroup',
                EntityType::class,
                [
                    'class' => AttributeGroup::class,
                    'choice_label' => 'name'
                ]
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\Attribute'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_attribute';
    }


}
