<?php

namespace BioprogrammeMarketingBundle\Form;

use BioprogrammeAccountBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'toUser',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => 'fullname',
                    'attr' => [
                        'class' => 'select2',
                        'multiple' => 'multiple'
                    ]
                ]
            )
            ->add('subject')
            ->add(
                'message',
                TextareaType::class,
                [
                    'attr' => [
                        'class' => 'wysihtml',
                    ]
                ]
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeMarketingBundle\Entity\Email'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammemarketingbundle_email';
    }


}
