<?php
namespace BioprogrammeMarketingBundle\DataFixtures\ORM;

use BioprogrammeAccountBundle\DataFixtures\ORM\UserFixture;
use BioprogrammeMarketingBundle\Entity\Email;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EmailFixture
 *
 * @package BioprogrammeMarketingBundle\DataFixtures\ORM
 */
class EmailFixture extends Fixture  implements ContainerAwareInterface
{
    protected $container;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $message = new Email();
        $message->setSubject('Хубави празници');
        $message->setMessage('Хубави празници');
        $message->setIsReaded(false);
        $message->setFromUser($this->getReference('to-user'));
        $message->setToUser($this->getReference('admin-user'));
        $manager->persist($message);
        $manager->flush();

        $message = new Email();
        $message->setSubject('Хубави празници');
        $message->setMessage('Хубави празници');
        $message->setIsReaded(false);
        $message->setFromUser($this->getReference('admin-user'));
        $message->setToUser($this->getReference('to-user'));
        $manager->persist($message);
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