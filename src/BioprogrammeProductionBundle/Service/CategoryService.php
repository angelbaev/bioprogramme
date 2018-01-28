<?php

namespace BioprogrammeProductionBundle\Service;

use BioprogrammeProductionBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

class CategoryService extends BaseService
{
    /**
     * CategoryService constructor.
     *
     * @param EntityManager  $entityManager
     * @param Container      $container
     * @param Category      $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}