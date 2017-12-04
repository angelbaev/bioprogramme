<?php
namespace AppBundle\EventListener;

use BioprogrammeAccountBundle\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class PermissionListener
 *
 * @package AppBundle\EventListener
 */
class PermissionListener implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $permissions = [];

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Role::class);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        if (method_exists($this->tokenStorage->getToken(),'getUser') &&
            is_object($this->tokenStorage->getToken()->getUser())
        ) {
            $currentRoute = $request->get('_route');

            if (!self::skipRouter($currentRoute)) {
                $this->permissions = $this->findPermissions(
                    $this->tokenStorage->getToken()->getUser()->getRoles()
                );

                $key = $request->isMethod('POST') ? 'modify' : 'access';

                if (!$this->hasPermission($key, $currentRoute)) {
                    // $event->getRequest()->getHost()
                    //$event->setResponse(new RedirectResponse('http://dev.biling.bioprogramme.net/app_dev.php/permission'));
                }
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 0)),
        );
    }

    /**
     * @param $roles
     *
     * @return array
     */
    private function findPermissions($roles)
    {
        $permissions = ['access' => [], 'modify' => []];
        $items = [];
        foreach ($this->repository->findBy(['code' => $roles]) as $role) {
            $permission = unserialize($role->getPermission());
            if (isset($permission['access']) && count($permission['access']) > count($permissions['access'])) {
                $permissions['access'] = $permission['access'];
            }
            if (isset($permission['modify']) && count($permission['modify']) > count($permissions['modify'])) {
                $permissions['modify'] = $permission['modify'];
            }
        }

        return $permissions;
    }

    /**
     * @param $key
     * @param $route
     *
     * @return bool
     */
    private function hasPermission($key, $route)
    {
        if (isset($this->permissions[$key])) {
            return in_array($route, $this->permissions[$key]);
        } else {
            return false;
        }
    }

    /**
     * @param $route
     *
     * @return bool
     */
    private static function skipRouter($route)
    {
        if (self::startsWith($route, '_')) {
            return true;
        }
        if (in_array($route, [
            'bioprogrammeaccount_default_index',
            'login',
            'auth_login_check',
            'logout',
            'homepage',
            'permission',
        ])) {
            return true;
        }

        return false;
    }

    /**
     * @param $haystack
     * @param $needle
     *
     * @return bool
     */
    private static function startsWith($haystack, $needle)
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}