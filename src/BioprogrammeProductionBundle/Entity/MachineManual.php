<?php

namespace BioprogrammeProductionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MachineManual
 *
 * @ORM\Table(name="machine_manual")
 * @ORM\Entity(repositoryClass="BioprogrammeProductionBundle\Repository\MachineManualRepository")
 */
class MachineManual
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
     * @ORM\Column(name="manual", type="text", nullable=true)
     */
    private $manual;

    /**
     * @ORM\OneToOne(targetEntity="Machine")
     * @ORM\JoinColumn(name="machine_id", referencedColumnName="id")
     */
    private $machine;


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
     * Set manual
     *
     * @param string $manual
     *
     * @return MachineManual
     */
    public function setManual($manual)
    {
        $this->manual = $manual;

        return $this;
    }

    /**
     * Get manual
     *
     * @return string
     */
    public function getManual()
    {
        return $this->manual;
    }

    /**
     * Set Machine
     *
     * @param Machine $machine
     *
     * @return MachineManual
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
}

