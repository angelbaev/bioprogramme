<?php
namespace BioprogrammeBranchBundle\Service;

use BioprogrammeBranchBundle\Entity\Branch;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class BranchService
 *
 * @package BioprogrammeBranchBundle\Service
 */
class BranchService extends BaseService
{
    /**
     * BranchService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Branch          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}