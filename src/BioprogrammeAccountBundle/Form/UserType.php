<?php

namespace BioprogrammeAccountBundle\Form;

use BioprogrammeAccountBundle\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
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
