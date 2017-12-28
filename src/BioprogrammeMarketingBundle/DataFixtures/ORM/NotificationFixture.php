<?php
namespace BioprogrammeMarketingBundle\DataFixtures\ORM;

use BioprogrammeAccountBundle\DataFixtures\ORM\UserFixture;
use BioprogrammeMarketingBundle\Entity\Notification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

//http://symfony.com/doc/master/bundles/DoctrineFixturesBundle/index.html#sharing-objects-between-fixtures

/**
 * Class NotificationFixture
 *
 * @package BioprogrammeMarketingBundle\DataFixtures\ORM
 */
class NotificationFixture extends Fixture  implements ContainerAwareInterface
{
    protected $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $notification = new Notification();
        $notification->setMessage('Тестова нотифицация');
        $notification->setIsReaded(false);
        $notification->setUser($this->getReference('admin-user'));
        $manager->persist($notification);
        $manager->flush();

        $notification = new Notification();
        $notification->setMessage('Тестова нотифицация');
        $notification->setIsReaded(false);
        $notification->setUser($this->getReference('to-user'));
        $manager->persist($notification);
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
            UserFixture::class,
        ];
    }
}