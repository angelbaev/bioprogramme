<?php

namespace BioprogrammeProductionBundle\Form;

use BioprogrammeProductionBundle\Entity\Attribute;
use BioprogrammeProductionBundle\Entity\BuildingBlock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingBlockAttributeReferenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'attribute',
                EntityType::class,
                [
                    'class' => Attribute::class,
                    'choice_label'=> 'name',
                    'placeholder' => 'Select',
                    'label' => 'Param',
                    'attr' => [
                        'class' => 'attribute select2'
                    ]
                ]
            )
            ->add('text');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\BuildingBlockAttributeReference'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_buildingblockAttributereference';
    }


}
