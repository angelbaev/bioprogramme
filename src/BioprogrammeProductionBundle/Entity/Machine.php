<?php

namespace BioprogrammeProductionBundle\Entity;

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
     * @var float
     *
     * @ORM\Column(name="quantity", type="float")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="serial_number", type="string", length=64)
     */
    private $serialNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="warranty", type="string", length=255)
     */
    private $warranty;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state;

    /**
     * @var int
     *
     * @ORM\Column(name="year_production", type="integer", nullable=true)
     */
    private $yearProduction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deployment", type="datetime", nullable=true)
     */
    private $dateDeployment;

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
     * @var string
     *
     * @ORM\Column(name="weight", type="decimal", precision=15, scale=4, nullable=true)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="length", type="decimal", precision=15, scale=8, nullable=true)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="decimal", precision=15, scale=8, nullable=true)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="decimal", precision=15, scale=8, nullable=true)
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

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
     * @var Category[]
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="machines")
     * @JoinTable(name="machine_to_category")
     */
    protected $categories;

    /**
     * @ORM\OneToMany(targetEntity="MachineAttributeReference", mappedBy="machine")
     */
    private $attributes;

    /**
     * @ORM\OneToOne(targetEntity="MachineManual", mappedBy="machine")
     */
    private $manual;

    /**
     * @ORM\OneToMany(targetEntity="MachineDocument", mappedBy="machine")
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
     * Machine constructor.
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->categories = new ArrayCollection();
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
     * Set quantity
     *
     * @param float $quantity
     *
     * @return Machine
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
     * Set weight
     *
     * @param string $weight
     *
     * @return Machine
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set length
     *
     * @param string $length
     *
     * @return Machine
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set width
     *
     * @param string $width
     *
     * @return Machine
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param string $height
     *
     * @return Machine
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set sortOrder
     *
     * @param integer $sortOrder
     *
     * @return Machine
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
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
     * Set serial number
     *
     * @param string $serialNumber
     *
     * @return Machine
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Get serial number
     *
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * Set warranty
     *
     * @param string $warranty
     *
     * @return Machine
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
     * Set Year Production
     *
     * @param int $yearProduction
     *
     * @return Machine
     */
    public function setYearProduction($yearProduction)
    {
        $this->yearProduction = $yearProduction;

        return $this;
    }

    /**
     * Get Year Production
     *
     * @return int
     */
    public function getYearProduction()
    {
        return $this->yearProduction;
    }

    /**
     * Set Date Deployment
     *
     * @param \DateTime $dateDeployment
     *
     * @return Machine
     */
    public function setDateDeployment($dateDeployment)
    {
        $this->dateDeployment = $dateDeployment;

        return $this;
    }

    /**
     * Get Date Deployment
     *
     * @return \DateTime
     */
    public function getDateDeployment()
    {
        return $this->dateDeployment;
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
     * Get Categories
     *
     * @return Machine
     */
    public function getCategories()
    {
        return $this->categories->toArray();
    }

    /**
     * Add Category
     *
     * @param Category $category
     * @return Machine
     */
    public function addCategory(Category $category)
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->categories->add($category);
        $category->addMachine($this);

        return $this;
    }

    /**
     * Remove Category
     *
     * @param Category $category
     * @return Machine
     */
    public function removeCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            return;
        }
        $this->categories->removeElement($category);
        $category->removeMachine($this);

        return $this;
    }

    /**
     * Get Attributes
     *
     * @return Machine
     */
    public function getAttributes()
    {
        return $this->attributes->toArray();
    }

    /**
     * Add Attribute
     *
     * @param Attribute $category
     * @return Machine
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
     * @return Machine
     */
    public function removeAttribute(Attribute $attribute)
    {
        if ($this->attributes->contains($attribute)) {
            $this->attributes->removeElement($attribute);
        }

        return $this;
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

