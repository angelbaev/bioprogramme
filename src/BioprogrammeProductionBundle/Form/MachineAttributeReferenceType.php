<?php

namespace BioprogrammeProductionBundle\Form;

use BioprogrammeProductionBundle\Entity\Attribute;
use BioprogrammeProductionBundle\Entity\Machine;
use BioprogrammeProductionBundle\Entity\MachineAttributeReference;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineAttributeReferenceType extends AbstractType
{
    private $em;
    private $requestStack;
    public function __construct(EntityManagerInterface $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'machine',
                EntityType::class,
                [
                    'class' => Machine::class,
                    'choice_label'=> 'name',
                    'label' => FALSE,
                    'attr' => [
                        'class' => 'hidden'
                    ]
                ]
            )
            ->add(
                'attribute',
                EntityType::class,
                [
                    'class' => Attribute::class,
                    'choice_label'=> 'name',
                    'placeholder' => 'Select'
                ]
            )
            ->add('text');

       //$builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);

    }

    /**
     * @param FormEvent $event
     */
    public function onPreSetData(FormEvent $event) {
        $form = $event->getForm();

        $machineId = $this->requestStack->getCurrentRequest()->get('id');
        $machineRepository = $this->em->getRepository(Machine::class);

        $machine = $machineRepository->findOneBy(['id' => $machineId]);
        if (!is_null($machine)) {
            $machine = [$machine];
        }

        $form->add(
            'machine',
            EntityType::class,
            [
                'class' => Machine::class,
                'choice_label'=> 'name',
                'choices' => $machine,
                'required' => true,
                'attr' => [
                    'disabled' => true
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BioprogrammeProductionBundle\Entity\MachineAttributeReference'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bioprogrammeproductionbundle_machineattributereference';
    }


}
