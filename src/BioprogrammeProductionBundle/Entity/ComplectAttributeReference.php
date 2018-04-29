<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ComplectAttributeReference
 *
 * @ORM\Table(name="complect_attribute_reference")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\ComplectAttributeReferenceRepository")
 */
class ComplectAttributeReference
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
     * @var float
     *
     * @ORM\Column(name="quantity", type="float", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="BioprogrammeProductionBundle\Entity\Complect")
     * @ORM\JoinColumn(name="complect_id", referencedColumnName="id")
     */
    private $complect;

    /**
     * @ORM\ManyToOne(targetEntity="BuildingBlock")
     * @ORM\JoinColumn(name="building_block_id", referencedColumnName="id")
     */
    private $buildingBlock;

    /**
     * @ORM\OneToMany(targetEntity="BuildingBlockAttributeReference", mappedBy="complect")
     */
    private $attributes;

    /**
     * BuildingBlock constructor.
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
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
     * Set quantity
     *
     * @param float $quantity
     *
     * @return ComplectAttributeReference
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
     * Set BuildingBlock
     *
     * @param BuildingBlock $block
     *
     * @return ComplectAttributeReference
     */
    public function setBuildingBlock(BuildingBlock $block)
    {
        $this->buildingBlock = $block;

        return $this;
    }

    /**
     * Get BuildingBlock
     * @return BuildingBlock
     */
    public function getBuildingBlock()
    {
        return $this->buildingBlock;
    }

    /**
     * Set Complect
     *
     * @param Complect $complect
     *
     * @return ComplectAttributeReference
     */
    public function setComplect(Complect $complect)
    {
        $this->complect = $complect;

        return $this;
    }

    /**
     * Get Complect
     * @return Complect
     */
    public function getComplect()
    {
        return $this->complect;
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
}

