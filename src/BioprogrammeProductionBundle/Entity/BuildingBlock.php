<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BuildingBlock
 *
 * @ORM\Table(name="building_block")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\BuildingBlockRepository")
 * @ORM\HasLifecycleCallbacks
 */
class BuildingBlock
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
     * @ORM\Column(name="model", type="string", length=65)
     */
    private $model;

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
     * @ORM\Column(name="warranty", type="string", length=160, nullable=true)
     */
    private $warranty;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="float", nullable=true)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="weight_val", type="string", length=25, nullable=true)
     */
    private $weightVal;

    /**
     * @var float
     *
     * @ORM\Column(name="length", type="float", nullable=true)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="length_val", type="string", length=25, nullable=true)
     */
    private $lengthVal;

    /**
     * @var float
     *
     * @ORM\Column(name="height", type="float", nullable=true)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="height_val", type="string", length=25, nullable=true)
     */
    private $heightVal;

    /**
     * @var float
     *
     * @ORM\Column(name="width", type="float", nullable=true)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="width_val", type="string", length=25, nullable=true)
     */
    private $widthVal;

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
     * @ORM\OneToMany(targetEntity="BuildingBlockAttributeReference", mappedBy="buildingBlock")
     */
    private $attributes;

    /**
     * @ORM\ManyToMany(targetEntity="Complect", mappedBy="buildingBlocks")
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
     * BuildingBlock constructor.
     */
    public function __construct()
    {
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
     * Set name
     *
     * @param string $name
     *
     * @return BuildingBlock
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
     * Set number
     *
     * @param string $number
     *
     * @return BuildingBlock
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
     * Set model
     *
     * @param string $model
     *
     * @return BuildingBlock
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
     * Set description
     *
     * @param string $description
     *
     * @return BuildingBlock
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
     * Set warranty
     *
     * @param string $warranty
     *
     * @return BuildingBlock
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
     * Set weight
     *
     * @param float $weight
     *
     * @return BuildingBlock
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set length
     *
     * @param float $length
     *
     * @return BuildingBlock
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set height
     *
     * @param float $height
     *
     * @return BuildingBlock
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width
     *
     * @param float $width
     *
     * @return BuildingBlock
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set weightVal
     *
     * @param string $weightVal
     *
     * @return BuildingBlock
     */
    public function setWeightVal($weightVal)
    {
        $this->weightVal = $weightVal;

        return $this;
    }

    /**
     * Get weightVal
     *
     * @return string
     */
    public function getWeightVal()
    {
        return $this->weightVal;
    }

    /**
     * Set lengthVal
     *
     * @param string $lengthVal
     *
     * @return BuildingBlock
     */
    public function setLengthVal($lengthVal)
    {
        $this->lengthVal = $lengthVal;

        return $this;
    }

    /**
     * Get lengthVal
     *
     * @return string
     */
    public function getLengthVal()
    {
        return $this->lengthVal;
    }

    /**
     * Set heightVal
     *
     * @param string $heightVal
     *
     * @return BuildingBlock
     */
    public function setHeightVal($heightVal)
    {
        $this->heightVal = $heightVal;

        return $this;
    }

    /**
     * Get heightVal
     *
     * @return string
     */
    public function getHeightVal()
    {
        return $this->heightVal;
    }

    /**
     * Set widthVal
     *
     * @param string $widthVal
     *
     * @return BuildingBlock
     */
    public function setWidthVal($widthVal)
    {
        $this->widthVal = $widthVal;

        return $this;
    }

    /**
     * Get widthVal
     *
     * @return string
     */
    public function getWidthVal()
    {
        return $this->widthVal;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return BuildingBlock
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
     * Set image
     *
     * @param string $image
     *
     * @return BuildingBlock
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
     * Set Manufacturer
     *
     * @param Manufacturer $manufacturer
     *
     * @return BuildingBlock
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get Manufacturer
     *
     * @return BuildingBlock
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Get Attributes
     *
     * @return BuildingBlock
     */
    public function getAttributes()
    {
        return $this->attributes->toArray();
    }

    /**
     * Add Attribute
     *
     * @param Attribute $category
     * @return BuildingBlock
     */
    public function addAttribute(Attribute $attribute)
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
        }

        return $this;
    }

    /**
     * Remove Attribute
     *
     * @param Attribute $category
     * @return BuildingBlock
     */
    public function removeAttribute(Attribute $attribute)
    {
        if ($this->attributes->contains($attribute)) {
            $this->attributes->removeElement($attribute);
        }

        return $this;
    }

    /**
     * Get complects
     * @return BuildingBlock
     */
    public function getComplects() {
        return $this->complects->toArray();
    }

    /**
     * Add complect
     *
     * @param Complect $complect
     * @return BuildingBlock
     */
    public function addComplect(Complect $complect) {
        if (!$this->complects->contains($complect)) {
            $this->complects->add($complect);
        }

        return $this;
    }

    /**
     *  Remove complect
     *
     * @param Complect $complect
     * @return BuildingBlock
     */
    public function removeComplect(Complect $complect) {
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

