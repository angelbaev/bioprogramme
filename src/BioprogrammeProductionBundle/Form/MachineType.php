<?php

namespace BioprogrammeProductionBundle\Form;

use AppBundle\Form\Type\ImageType;
use BioprogrammeBranchBundle\Entity\Base;
use BioprogrammeBranchBundle\Entity\Building;
use BioprogrammeBranchBundle\Entity\Line;

use BioprogrammeProductionBundle\Entity\Machine;
use BioprogrammeProductionBundle\Entity\Manufacturer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MachineType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('model')
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
            ->add('state')
            ->add('image', ImageType::class)
            ->add(
                'manufacturer',
                EntityType::class,
                [
                    'class' => Manufacturer::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Select'
                ]
            )
            ->add('price')
            ->add('isActive');

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
    }


    public function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        $base = $this->em->getRepository(Base::class)->find($data['base']);
        $building = $this->em->getRepository(Building::class)->find($data['building']);

        $this->addElements($form, $base, $building);
    }

    public function onPreSetData(FormEvent $event) {
        $machine = $event->getData();
        $form = $event->getForm();

        $base = $machine->getBase() ? $machine->getBase() : null;
        $building = $machine->getBuilding() ? $machine->getBuilding() : null;

         $this->addElements($form, $base, $building);
    }

    /**
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

    /**
     * Add elements
     * @param FormInterface $form
     * @param Base          $base
     * @param Building      $line
     */
    protected function addElements(FormInterface $form,  Base $base = null, Building $building = null) {

        $form->add(
            'base',
            EntityType::class,
            [
                'class' => Base::class,
                'choice_label' => 'name',
                'data' => $base,
                'required' => true,
                'placeholder' => 'Select',
                'attr' => [
                    'class' => 'select2',
                ]
            ]
        );

        $buildings = [];
        $lines = [];

        if ($base) {
            $repositoryBuilding = $this->em->getRepository(Building::class);
            $buildings = $repositoryBuilding->findBy(['base' => $base->getId()]);
        }

        if ($building) {
            $repositoryLine = $this->em->getRepository(Line::class);
            $lines = $repositoryLine->findBy(['building' => $building->getId()]);
        }

        $form->add(
            'building',
            EntityType::class,
            [
                'class' => Building::class,
                'choice_label' => 'name',
                'choices' => $buildings,
                'required' => true,
                'placeholder' => 'Select',
                'attr' => [
                    'class' => 'select2',
                ]
            ]
        );

        $form->add(
            'line',
            EntityType::class,
            [
                'class' => Line::class,
                'choice_label' => 'name',
                'choices' => $lines,
                'required' => false,
                'placeholder' => 'Select',
                'attr' => [
                    'class' => 'select2',
                ]
            ]
        );
    }
}
