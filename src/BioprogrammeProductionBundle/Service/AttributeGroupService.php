<?php

namespace BioprogrammeProductionBundle\Service;

use BioprogrammeProductionBundle\Entity\AttributeGroup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class AttributeGroupService
 *
 * @package BioprogrammeProductionBundle\Service
 */
class AttributeGroupService extends BaseService
{
    /**
     * AttributeGroupService constructor.
     *
     * @param EntityManager  $entityManager
     * @param Container      $container
     * @param AttributeGroup $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}