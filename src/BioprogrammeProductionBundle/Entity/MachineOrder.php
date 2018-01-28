<?php

namespace BioprogrammeProductionBundle\Entity;

use BioprogrammeBranchBundle\Entity\Base;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * MachineOrder
 *
 * @ORM\Table(name="machine_order")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\MachineOrderRepository")
 * @ORM\HasLifecycleCallbacks
 */
class MachineOrder
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
     * @ORM\Column(name="serial_number", type="string", length=64)
     */
    private $serialNumber;

    /**
     * @ORM\ManyToOne(targetEntity="BioprogrammeBranchBundle\Entity\Base")
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     */
    private $base;

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
     * @ManyToMany(targetEntity="MachineOrderReference", mappedBy="machineOrder")
     */
    private $machineOrderReferences;

    public function __construct()
    {
        $this->machineOrderReferences = new ArrayCollection();
    }

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
     * Set serialNumber
     *
     * @param string $serialNumber
     *
     * @return MachineOrder
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Get serialNumber
     *
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Set base
     *
     * @param Base $base
     *
     * @return MachineOrder
     */
    public function setBase(Base $base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return MachineOrder
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Get Machine Order References
     * @return MachineOrder
     */
    public function getMachineOrderReferences() {
        return $this->machineOrderReferences->toArray();
    }

    /**
     * Add Machine Order References
     *
     * @param MachineOrderReference $machineOrderReference
     * @return MachineOrder
     */
    public function addPost(MachineOrderReference $machineOrderReference) {
        if (!$this->machineOrderReferences->contains($machineOrderReference)) {
            $this->machineOrderReferences->add($machineOrderReference);
        }

        return $this;
    }

    /**
     *  Remove Machine Order References
     *
     * @param MachineOrderReference $machineOrderReference
     * @return MachineOrder
     */
    public function removePost(MachineOrderReference $machineOrderReference) {
        if ($this->machineOrderReferences->contains($machineOrderReference)) {
            $this->machineOrderReferences->removeElement($machineOrderReference);
        }

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MachineOrder
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
     * @return MachineOrder
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

