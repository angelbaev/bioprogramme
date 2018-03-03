<?php

namespace BioprogrammeBranchBundle\Entity;

use BioprogrammeProductionBundle\Entity\Machine;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Building
 *
 * @ORM\Table(name="building")
 * @ORM\Entity(repositoryClass="BioprogrammeBranchBundle\Repository\BuildingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Building
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
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Base")
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     */
    private $base;

    /**
     * @ORM\OneToMany(targetEntity="Line", mappedBy="building")
     */
    private $lines;

    /**
     * @ORM\OneToMany(targetEntity="BioprogrammeProductionBundle\Entity\Machine", mappedBy="building")
     */
    private $machines;

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
     * @var int
     *
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $createdBy;

    /**
     * @var int
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    private $updatedBy;

    /**
     * Building constructor.
     */
    public function __construct()
    {
        $this->lines = new ArrayCollection();
        $this->machines = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Building
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Building
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set base
     *
     * @param Base $base
     *
     * @return Building
     */
    public function setBase(Base $base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return Building
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Get lines
     * @return Line[]
     */

    public function getLines() {
        return $this->lines->toArray();
    }

    /**
     * Add line
     *
     * @param Line $line
     * @return Building
     */
    public function addLine(Line $line) {
        if (!$this->lines->contains($line)) {
            $this->lines->add($line);
        }

        return $this;
    }

    /**
     *  Remove line
     *
     * @param Line $line
     * @return Building
     */
    public function removeLine(Line $line) {
        if ($this->lines->contains($line)) {
            $this->lines->removeElement($line);
        }

        return $this;
    }

    /**
     * Get machines
     * @return Machine[]
     */

    public function getMachines() {
        return $this->machines->toArray();
    }

    /**
     * Add machine
     *
     * @param Machine $machine
     * @return Building
     */
    public function addMachine(Machine $machine) {
        if (!$this->machines->contains($machine)) {
            $this->machines->add($machine);
        }

        return $this;
    }

    /**
     *  Remove machine
     *
     * @param Machine $machine
     * @return Building
     */
    public function removeMachine(Machine $machine) {
        if ($this->machines->contains($machine)) {
            $this->machines->removeElement($machine);
        }

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Building
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
     * @return Building
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
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return Building
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param integer $updatedBy
     *
     * @return Building
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
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

