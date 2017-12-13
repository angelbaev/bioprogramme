<?php
namespace BioprogrammeBranchBundle\DataFixtures\ORM;

use BioprogrammeBranchBundle\Entity\Branch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BranchFixture
 *
 * @package BioprogrammeBranchBundle\DataFixtures\ORM
 */
class BranchFixture extends Fixture  implements ContainerAwareInterface
{
    protected $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Bioprogramme Bulgaria
        $branch = new Branch();
        $branch->setName('Биопрограма България');
        $branch->setDescription('Биопрограма България');
        $manager->persist($branch);
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