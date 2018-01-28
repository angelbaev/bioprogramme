<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MachineOrderHistory
 *
 * @ORM\Table(name="machine_order_history")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\MachineOrderHistoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class MachineOrderHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="MachineOrder")
     * @ORM\JoinColumn(name="machine_order_id", referencedColumnName="id")
     */
    private $machineOrder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return MachineOrderHistory
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set Machine order
     *
     * @param MachineOrder $machineOrder
     *
     * @return MachineOrderHistory
     */
    public function setMachineOrder(MachineOrder $machineOrder)
    {
        $this->machineOrder = $machineOrder;

        return $this;
    }

    /**
     * Get Machine order
     *
     * @return MachineOrderHistory
     */
    public function getMachineOrder()
    {
        return $this->machineOrder;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MachineOrderHistory
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MachineOrderHistory
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }
}

