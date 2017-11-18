<?php
namespace BioprogrammeAccountBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use BioprogrammeAccountBundle\Entity\Role;
use AppBundle\Service\BaseService;

/**
 * Class PositionService
 *
 * @package BioprogrammeAccountBundle\Service
 */
class PositionService extends BaseService
{
    /**
     * PositionService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Role          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}