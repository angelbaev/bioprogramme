<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuildingBlockAttributeReference
 *
 * @ORM\Table(name="building_block_attribute_reference")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\BuildingBlockAttributeReferenceRepository")
 */
class BuildingBlockAttributeReference
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
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="BuildingBlock")
     * @ORM\JoinColumn(name="building_block_id", referencedColumnName="id")
     */
    private $buildingBlock;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id")
     */
    private $attribute;


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
     * Set text
     *
     * @param string $text
     *
     * @return BuildingBlockAttributeReference
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set BuildingBlock
     *
     * @param BuildingBlock $machine
     *
     * @return BuildingBlockAttributeReference
     */
    public function setBuildingBlock(BuildingBlock $block)
    {
        $this->buildingBlock = $block;

        return $this;
    }

    /**
     * Get Machine
     *
     * @return BuildingBlock
     */
    public function getBuildingBlock()
    {
        return $this->buildingBlock;
    }

    /**
     * Set Attribute
     *
     * @param Attribute $attribute
     *
     * @return BuildingBlockAttributeReference
     */
    public function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get Attribute
     *
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}

