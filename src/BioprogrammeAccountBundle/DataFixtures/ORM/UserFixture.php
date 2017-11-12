<?php
namespace BioprogrammeAccountBundle\DataFixtures\ORM;

use BioprogrammeAccountBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

// php bin/console doctrine:fixtures:load

/**
 * Class UserFixture
 *
 * @package BioprogrammeAccountBundle\DataFixtures\ORM
 */
class UserFixture extends Fixture  implements ContainerAwareInterface
{
    protected $container;

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        $user = new User();
        $user->setUserName('admin');
        $user->setEmail('admin@bioprogramme.net');
        $user->setFullName('bioprogramme admin');
        $user->setPhone('123456');
        $user->setIsActive(1);
        $password = $encoder->encodePassword($user, '123#');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();


        $user = new User();
        $user->setUserName('vasoto');
        $user->setEmail('vasoto@etko.info');
        $user->setFullName('Vasil Hvurchilkov');
        $user->setPhone('123456');
        $user->setIsActive(1);
        $password = $encoder->encodePassword($user, '123#');
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();



        // create 20 users!
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUserName('demo' . $i);
            $user->setEmail('demo' . $i . '@abv.bg');
            $user->setFullName('Demo Demov');
            $user->setPhone(mt_rand(10, 100));
            $user->setIsActive(1);
            $password = $encoder->encodePassword($user, '0000');
            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}