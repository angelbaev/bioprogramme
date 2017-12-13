<?php
namespace BioprogrammeBranchBundle\Service;

use BioprogrammeBranchBundle\Entity\Building;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class BuildingService
 *
 * @package BioprogrammeBranchBundle\Service
 */
class BuildingService extends BaseService
{
    /**
     * BuildingService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Building          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}