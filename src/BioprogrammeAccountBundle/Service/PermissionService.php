<?php
namespace BioprogrammeAccountBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use BioprogrammeAccountBundle\Entity\Role;
use AppBundle\Service\BaseService;

/**
 * Class PermissionService
 *
 * @package BioprogrammeAccountBundle\Service
 */
class PermissionService extends BaseService
{

    /**
     * PermissionService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Role          $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }

    /**
     * @param array $routes
     *
     * @return array
     */
    public function  convertRouteCollection(array $routes)
    {
        $data = [];
        foreach ($routes as $route => $params) {
            if ($this->startsWith($route, '_')) continue;
            if (in_array($route, [
                'bioprogrammeaccount_default_index',
                'bioprogrammesetting_default_index',
                'login',
                'auth_login_check',
                'logout',
                'homepage',
                'permission',
            ]))  continue;
            $data[] = $route;
        }

        return $data;
    }

    /**
     * @param $haystack
     * @param $needle
     *
     * @return bool
     */
    public function startsWith($haystack, $needle)
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}