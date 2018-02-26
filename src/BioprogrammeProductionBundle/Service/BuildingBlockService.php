<?php

namespace BioprogrammeProductionBundle\Service;

use BioprogrammeProductionBundle\Entity\BuildingBlock;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

class BuildingBlockService extends BaseService
{
    /**
     * BuildingBlockService constructor.
     *
     * @param EntityManager  $entityManager
     * @param Container      $container
     * @param BuildingBlock  $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}