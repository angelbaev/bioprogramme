<?php
namespace BioprogrammeBranchBundle\DataFixtures\ORM;

use BioprogrammeBranchBundle\Entity\Base;
use BioprogrammeBranchBundle\Entity\Branch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BaseFixture
 *
 * @package BioprogrammeBranchBundle\DataFixtures\ORM
 */
class BaseFixture extends Fixture  implements ContainerAwareInterface
{
    protected $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $base = new Base();
        $base->setName('Антоново');
        $base->setPhone('123456');
        $base->setIsActive(true);
        $manager->persist($base);
        $manager->flush();
    }

    /**
     * @param ContainerInterface|NULL $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}