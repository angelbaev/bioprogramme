<?php
namespace BioprogrammeBranchBundle\DataFixtures\ORM;

use BioprogrammeBranchBundle\Entity\Base;
use BioprogrammeBranchBundle\Entity\Branch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BaseFixture
 *
 * @package BioprogrammeBranchBundle\DataFixtures\ORM
 */
class BaseFixture extends Fixture  implements ContainerAwareInterface, DependentFixtureInterface
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
        $base->setBranch($this->getReference('bioprograma-branch'));
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

    /**
     * @inheritdoc
     */
    public function getDependencies()
    {
        return [
            BranchFixture::class,
        ];
    }
}