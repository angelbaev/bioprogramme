<?php
namespace BioprogrammeSettingBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use BioprogrammeSettingBundle\Entity\City;
use AppBundle\Service\BaseService;

/**
 * Class CityService
 *
 * @package BioprogrammeSettingBundle\Service
 */
class CityService extends BaseService
{
    /**
     * CountryService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param City          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }
}