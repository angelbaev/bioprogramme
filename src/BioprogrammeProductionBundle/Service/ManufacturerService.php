<?php

namespace BioprogrammeProductionBundle\Service;

use BioprogrammeProductionBundle\Entity\Manufacturer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class ManufacturerService
 *
 * @package BioprogrammeProductionBundle\Service
 */
class ManufacturerService extends BaseService
{
    /**
     * ManufacturerService constructor.
     *
     * @param EntityManager  $entityManager
     * @param Container      $container
     * @param Manufacturer   $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}