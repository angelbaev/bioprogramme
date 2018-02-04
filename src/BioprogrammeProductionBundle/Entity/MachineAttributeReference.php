<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MachineAttributeReference
 *
 * @ORM\Table(name="machine_attribute_reference")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\MachineAttributeReferenceRepository")
 */
class MachineAttributeReference
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
     * @ORM\ManyToOne(targetEntity="Machine")
     * @ORM\JoinColumn(name="machine_id", referencedColumnName="id")
     */
    private $machine;

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
     * @return MachineAttributeReference
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
     * Set Machine
     *
     * @param Machine $machine
     *
     * @return MachineAttributeReference
     */
    public function setMachine(Machine $machine)
    {
        $this->machine = $machine;

        return $this;
    }

    /**
     * Get Machine
     *
     * @return Machine
     */
    public function getMachine()
    {
        return $this->machine;
    }

    /**
     * Set Attribute
     *
     * @param Attribute $attribute
     *
     * @return MachineAttributeReference
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

