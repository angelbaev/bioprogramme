<?php

namespace BioprogrammeProductionBundle\Service;

use BioprogrammeProductionBundle\Entity\Complect;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

class ComplectService extends BaseService
{
    /**
     * ComplectService constructor.
     *
     * @param EntityManager  $entityManager
     * @param Container      $container
     * @param Complect       $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}