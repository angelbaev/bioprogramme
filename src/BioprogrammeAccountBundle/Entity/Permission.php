<?php

namespace BioprogrammeAccountBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Permission
 *
 * @ORM\Table(name="permission")
 * @ORM\Entity(repositoryClass="BioprogrammeAccountBundle\Repository\PermissionRepository")
 */
class Permission
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
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="permissions")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="roles")
     */
    private $roles;

    /**
     * Permission constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
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
     * @return Permission
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
     * Set value
     *
     * @param integer $value
     *
     * @return Permission
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get Users
     * @return User
     */
    public function getUsers() {
        return $this->users->toArray();
    }

    /**
     * Add User
     *
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user) {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    /**
     * Remove User
     *
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user) {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * Get Roles
     * @return Role
     */
    public function getRoles() {
        return $this->roles->toArray();
    }

    /**
     * Add Role
     *
     * @param Role $role
     *
     * @return $this
     */
    public function addRole(Role $role) {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * Remove Role
     *
     * @param Role $role
     *
     * @return $this
     */
    public function removeRole(Role $role) {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }
}

