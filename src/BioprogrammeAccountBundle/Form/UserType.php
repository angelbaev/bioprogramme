<?php

namespace BioprogrammeAccountBundle\Form;

use BioprogrammeAccountBundle\Entity\Position;
use BioprogrammeAccountBundle\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username')
            ->add('email', EmailType::class)
            ->add('fullName')
            ->add('phone')
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                //'expanded' => true, // render check-boxes
                'choices' => $this->getRoles()
            ])
            ->add(
                'position',
                EntityType::class,
                [
                    'class' => Position::class,
                    'choice_label' => 'name'
                ]
            )

//            ->add(
//                'roles',
//                EntityType::class,
//                [
//                    'class' => Role::class,
//                    'choice_label' => 'name',
//                    'multiple'  => true,
//                    'required' => false,
//                ]
//            )
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'required' => false,
            ])
            ->add('isActive');

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            // Retrieve submitted data
            $form = $event->getForm();
            $item = $event->getData();

            if (null === $form->get('password')->getData()) {
                //$form->remove('password');
            }
         });
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            // Retrieve submitted data
            $form = $event->getForm();
            $item = $event->getData();

            if (null === $form->get('password')->getData()) {
                //$form->remove('password');
            }
/*
            // Test if upload image is null (maybe adapt it to work with your code)
            if (null !== $form->get('image')->getData()) {
                var_dump($form->get('image')->getData());
                die('image provided');
                $item->setImage($form->get('image')->getData());
            }
            */
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeAccountBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeaccountbundle_user';
    }

    private function getRoles()
    {
        $repository = $this->em->getRepository(Role::class);
        $results = $repository->findBy(['isActive' => 1]);
        $roles = [];
        foreach($results as $result) {
            $roles[$result->getName()] = $result->getCode();
        }

        return $roles;
    }
}
