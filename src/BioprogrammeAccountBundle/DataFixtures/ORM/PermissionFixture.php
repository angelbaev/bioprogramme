<?php
namespace BioprogrammeAccountBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PermissionFixture
 *
 * @package BioprogrammeAccountBundle\DataFixtures\ORM
 */
class PermissionFixture extends Fixture  implements ContainerAwareInterface
{
    protected $container;

    public function load(ObjectManager $manager)
    {

    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}