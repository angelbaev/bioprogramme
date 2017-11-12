<?php
namespace BioprogrammeAccountBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use BioprogrammeAccountBundle\Entity\User;
use AppBundle\Service\BaseService;
/**
 * Class UserService
 *
 * @package BioprogrammeAccountBundle\Service
 */
class UserService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param User          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}