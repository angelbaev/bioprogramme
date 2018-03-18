<?php

namespace BioprogrammeProductionBundle\Entity;

use BioprogrammeBranchBundle\Entity\Base;
use BioprogrammeBranchBundle\Entity\Building;
use BioprogrammeBranchBundle\Entity\Line;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * Machine
 *
 * @ORM\Table(name="machine")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\MachineRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Machine
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
     * @ORM\Column(name="model", type="string", length=64)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=65)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=15, scale=4)
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Manufacturer")
     * @ORM\JoinColumn(name="manufacturer_id", referencedColumnName="id")
     */
    private $manufacturer;

    /**
     * @ORM\ManyToOne(targetEntity="BioprogrammeBranchBundle\Entity\Base")
     * @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     */
    private $base;

    /**
     * @ORM\ManyToOne(targetEntity="BioprogrammeBranchBundle\Entity\Building")
     * @ORM\JoinColumn(name="building_id", referencedColumnName="id", nullable=true)
     */
    private $building;

    /**
     * @ORM\ManyToOne(targetEntity="BioprogrammeBranchBundle\Entity\Line")
     * @ORM\JoinColumn(name="line_id", referencedColumnName="id", nullable=true)
     */
    private $line;

    /**
     * @ORM\OneToOne(targetEntity="MachineManual", mappedBy="machine")
     */
    private $manual;

    /**
     * @ORM\OneToMany(targetEntity="MachineDocument", mappedBy="machine")
     */
    private $documents;

    /**
     * @ORM\ManyToMany(targetEntity="BioprogrammeProductionBundle\Entity\Complect")
     * @JoinTable(name="machine_to_complect")
     */
    private $complects;

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
     * Machine constructor.
     */
    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->complects = new ArrayCollection();
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
     * Set model
     *
     * @param string $model
     *
     * @return Machine
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Machine
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Machine
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
     * Set description
     *
     * @param string $description
     *
     * @return Machine
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Machine
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Machine
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Machine
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
     * Set Manufacturer
     *
     * @param Manufacturer $manufacturer
     *
     * @return Machine
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get Manufacturer
     *
     * @return Machine
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set Base
     *
     * @param Base $base
     *
     * @return Machine
     */
    public function setBase(Base $base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get Base
     *
     * @return Machine
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set Building
     *
     * @param Building $building
     *
     * @return Machine
     */
    public function setBuilding(Building $building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get Building
     *
     * @return Machine
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set Line
     *
     * @param Line $line
     *
     * @return Machine
     */
    public function setLine(Line $line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get Line
     *
     * @return Machine
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Set state
     *
     * @param int $state
     *
     * @return Machine
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set Manual
     *
     * @param MachineManual $manual
     *
     * @return Machine
     */
    public function setManual(MachineManual $manual)
    {
        $this->manual = $manual;

        return $this;
    }

    /**
     * Get Manual
     *
     * @return MachineManual
     */
    public function getManual()
    {
        return $this->manual;
    }

    /**
     * Get Documents
     *
     * @return Machine
     */
    public function getDocuments()
    {
        return $this->documents->toArray();
    }

    /**
     * Add Document
     *
     * @param MachineDocument $document
     * @return Machine
     */
    public function addDocument(MachineDocument $document)
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }

    /**
     * Remove Document
     *
     * @param MachineDocument $document
     * @return Machine
     */
    public function removeDocument(MachineDocument $document)
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
        }

        return $this;
    }

    /**
     * Get complects
     *
     * @return Machine
     */
    public function getComplects()
    {
        return $this->complects->toArray();
    }

    /**
     * Add complect
     *
     * @param Complect $complect
     * @return Machine
     */
    public function addComplect(Complect $complect)
    {
        if (!$this->complects->contains($complect)) {
            $this->complects->add($complect);
        }

        return $this;
    }

    /**
     * Remove complect
     *
     * @param Complect $complect
     * @return Machine
     */
    public function removeComplect(Complect $complect)
    {
        if ($this->complects->contains($complect)) {
            $this->complects->removeElement($complect);
        }

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Machine
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
     * @return Machine
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
     * @return Machine
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
     * @return Machine
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

