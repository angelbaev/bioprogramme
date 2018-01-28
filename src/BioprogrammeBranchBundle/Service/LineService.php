<?php
namespace BioprogrammeBranchBundle\Service;

use BioprogrammeBranchBundle\Entity\Line;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class LineService
 *
 * @package BioprogrammeBranchBundle\Service
 */
class LineService extends BaseService
{
    /**
     * LineService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Line          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}