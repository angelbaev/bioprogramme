<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Complect
 *
 * @ORM\Table(name="complect")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\ComplectRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Complect
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
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float", nullable=true)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="warranty", type="string", length=160, nullable=true)
     */
    private $warranty;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_manufacture", type="date", nullable=true)
     */
    private $dateOfManufacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_implementation", type="date", nullable=true)
     */
    private $dateImplementation;

    /**
     * @ORM\OneToMany(targetEntity="ComplectAttributeReference", mappedBy="complect")
     */
    private $buildingBlocks;
    /**
     * @ORM\ManyToOne(targetEntity="Manufacturer")
     * @ORM\JoinColumn(name="manufacturer_id", referencedColumnName="id")
     */
    private $manufacturer;

    /**
     * @ORM\OneToMany(targetEntity="BioprogrammeProductionBundle\Entity\ComplectDocument", mappedBy="complect")
     */
    private $documents;

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
     * Complect constructor.
     */
    public function __construct()
    {
        $this->buildingBlocks = new ArrayCollection();
        $this->documents = new ArrayCollection();
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
     * Set number
     *
     * @param string $number
     *
     * @return Complect
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
     * @return Complect
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
     * @return Complect
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
     * @return Complect
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
     * @return Complect
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
     * Set quantity
     *
     * @param float $quantity
     *
     * @return Complect
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set warranty
     *
     * @param string $warranty
     *
     * @return Complect
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return string
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Complect
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
     * Set dateOfManufacture
     *
     * @param \DateTime $dateOfManufacture
     *
     * @return Complect
     */
    public function setDateOfManufacture($dateOfManufacture)
    {
        $this->dateOfManufacture = $dateOfManufacture;

        return $this;
    }

    /**
     * Get dateOfManufacture
     *
     * @return \DateTime
     */
    public function getDateOfManufacture()
    {
        return $this->dateOfManufacture;
    }

    /**
     * Set dateImplementation
     *
     * @param \DateTime $dateImplementation
     *
     * @return Complect
     */
    public function setDateImplementation($dateImplementation)
    {
        $this->dateImplementation = $dateImplementation;

        return $this;
    }

    /**
     * Get dateImplementation
     *
     * @return \DateTime
     */
    public function getDateImplementation()
    {
        return $this->dateImplementation;
    }

    /**
     * Set Manufacturer
     *
     * @param Manufacturer $manufacturer
     *
     * @return Complect
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get Manufacturer
     *
     * @return Complect
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Get getBuildingBlocks
     *
     * @return Complect
     */
    public function getBuildingBlocks()
    {
        return $this->buildingBlocks->toArray();
    }

    /**
     * Add Building Block
     *
     * @param BuildingBlock $block
     * @return Complect
     */
    public function addBuildingBlock(BuildingBlock $block)
    {
        $block->addComplect($this);
        if (!$this->buildingBlocks->contains($block)) {
            $this->buildingBlocks->add($block);
        }

        return $this;
    }

    /**
     * Remove Category
     *
     * @param BuildingBlock $block
     * @return Complect
     */
    public function removeBuildingBlock(BuildingBlock $block)
    {
        $block->removeComplect($this);
        if ($this->buildingBlocks->contains($block)) {
            $this->buildingBlocks->removeElement($block);
        }

        return $this;
    }

    /**
     * Get Documents
     *
     * @return Complect
     */
    public function getDocuments()
    {
        return $this->documents->toArray();
    }

    /**
     * Add Document
     *
     * @param ComplectDocument $document
     * @return Machine
     */
    public function addDocument(ComplectDocument $document)
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }

    /**
     * Remove Document
     *
     * @param ComplectDocument $document
     * @return Machine
     */
    public function removeDocument(ComplectDocument $document)
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
        }

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return BuildingBlock
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
     * @return BuildingBlock
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
     * @return BuildingBlock
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
     * @return BuildingBlock
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

