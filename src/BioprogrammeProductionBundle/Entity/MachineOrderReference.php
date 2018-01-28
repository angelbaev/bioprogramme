<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MachineOrderReference
 *
 * @ORM\Table(name="machine_order_reference")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\MachineOrderReferenceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class MachineOrderReference
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="MachineOrder")
     * @ORM\JoinColumn(name="machine_order_id", referencedColumnName="id")
     */
    private $machineOrder;

    /**
     * @ORM\ManyToOne(targetEntity="Machine")
     * @ORM\JoinColumn(name="machine_id", referencedColumnName="id")
     */
    private $machine;

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
     * Set name
     *
     * @param string $name
     *
     * @return MachineOrderReference
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Machine order
     *
     * @param MachineOrder $machineOrder
     *
     * @return MachineOrderReference
     */
    public function setMachineOrder(MachineOrder $machineOrder)
    {
        $this->machineOrder = $machineOrder;

        return $this;
    }

    /**
     * Get Machine order
     *
     * @return MachineOrderReference
     */
    public function getMachineOrder()
    {
        return $this->machineOrder;
    }

    /**
     * Set Machine
     *
     * @param Machine $machine
     *
     * @return MachineOrderReference
     */
    public function setMachine(Machine $machine)
    {
        $this->machine = $machine;

        return $this;
    }

    /**
     * Get Machine
     *
     * @return MachineOrderReference
     */
    public function getMachine()
    {
        return $this->machine;
    }
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MachineOrderReference
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
     * @return MachineOrderReference
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

