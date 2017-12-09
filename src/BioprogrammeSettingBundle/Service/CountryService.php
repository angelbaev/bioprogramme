<?php
namespace BioprogrammeSettingBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use BioprogrammeSettingBundle\Entity\Country;
use AppBundle\Service\BaseService;

/**
 * Class CountryService
 *
 * @package BioprogrammeSettingBundle\Service
 */
class CountryService extends BaseService
{
    /**
     * CountryService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Country          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}