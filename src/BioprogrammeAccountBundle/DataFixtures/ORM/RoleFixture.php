<?php
namespace BioprogrammeAccountBundle\DataFixtures\ORM;

use BioprogrammeAccountBundle\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RoleFixture
 *
 * @package BioprogrammeAccountBundle\DataFixtures\ORM
 */
class RoleFixture extends Fixture  implements ContainerAwareInterface
{
    protected $container;

    public function load(ObjectManager $manager)
    {

        // Administrator
        $role = new Role();
        $role->setName('Administrator');
        $role->setCode('ROLE_ADMIN');
        $role->setIsActive(1);
        $manager->persist($role);
        $manager->flush();

        // Manager
        $role = new Role();
        $role->setName('Manager');
        $role->setCode('ROLE_MANAGER');
        $role->setIsActive(1);
        $manager->persist($role);
        $manager->flush();

        // Technical officer
        $role = new Role();
        $role->setName('Technical officer');
        $role->setCode('ROLE_TO');
        $role->setIsActive(1);
        $manager->persist($role);
        $manager->flush();

        // Work department
        $role = new Role();
        $role->setName('Work department');
        $role->setCode('ROLE_WP');
        $role->setIsActive(1);
        $manager->persist($role);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}