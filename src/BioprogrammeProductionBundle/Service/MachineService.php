<?php

namespace BioprogrammeProductionBundle\Service;

use BioprogrammeProductionBundle\Entity\Machine;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

class MachineService extends BaseService
{
    /**
     * MachineService constructor.
     *
     * @param EntityManager  $entityManager
     * @param Container      $container
     * @param Machine        $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}