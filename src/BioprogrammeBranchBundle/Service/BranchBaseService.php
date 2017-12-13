<?php
namespace BioprogrammeBranchBundle\Service;

use BioprogrammeBranchBundle\Entity\Base;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class BranchBaseService
 *
 * @package BioprogrammeBranchBundle\Service
 */
class BranchBaseService extends BaseService
{
    /**
     * BranchBaseService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Base          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}