<?php
namespace BioprogrammeMarketingBundle\Service;

use BioprogrammeMarketingBundle\Entity\Email;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class EmailService
 *
 * @package BioprogrammeMarketingBundle\Service
 */
class EmailService extends BaseService
{
    /**
     * EmailService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Email         $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}