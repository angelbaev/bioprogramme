<?php
namespace BioprogrammeMarketingBundle\Service;

use BioprogrammeMarketingBundle\Entity\Notification;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use AppBundle\Service\BaseService;

/**
 * Class NotificationService
 *
 * @package BioprogrammeMarketingBundle\Service
 */
class NotificationService extends BaseService
{
    /**
     * NotificationService constructor.
     *
     * @param EntityManager $entityManager
     * @param Container     $container
     * @param Notification  $entity
     */
    public function __construct(EntityManager $entityManager, Container $container, $entity)
    {
        parent::__construct($entityManager, $container, $entity);
    }

    /**
     * Update all recors as read
     *
     * @param $userId
     */
    public function updateAllAsRead($userId)
    {
        $query = $this->em->createQueryBuilder();
        $query->update(Notification::class, 'n')
            ->set('n.isReaded', '?1')
            ->setParameter(1, 1)
            ->where('n.user = ?2')
            ->setParameter(2, (int)$userId)
            ->getQuery()
            ->execute();

        $this->em->flush();
    }
}