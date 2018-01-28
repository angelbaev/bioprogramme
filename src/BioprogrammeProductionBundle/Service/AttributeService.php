<?php

namespace BioprogrammeProductionBundle\Service;

use BioprogrammeProductionBundle\Entity\Attribute;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class AttributeService
 *
 * @package BioprogrammeProductionBundle\Service
 */
class AttributeService extends BaseService
{
    /**
     * AttributeService constructor.
     *
     * @param EntityManager  $entityManager
     * @param Container      $container
     * @param Attribute      $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}