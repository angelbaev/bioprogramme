<?php
namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class EntityOwnerAssignmentListener
 *
 * @package AppBundle\EventListener
 */
class EntityOwnerAssignmentListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if(method_exists(get_class($entity), 'setCreatedBy')){
            $entity->setCreatedBy(
                $this->tokenStorage->getToken()->getUser()->getId()
            );
        }
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if(method_exists(get_class($entity), 'setUpdatedBy')){
            $entity->setUpdatedBy(
                $this->tokenStorage->getToken()->getUser()->getId()
            );
        }
    }
}