<?php

namespace BioprogrammeMarketingBundle\Entity;

use BioprogrammeAccountBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="BioprogrammeMarketingBundle\Repository\EmailRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Email
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
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_readed", type="boolean")
     */
    private $isReaded;

    /**
     * @ORM\ManyToOne(targetEntity="BioprogrammeAccountBundle\Entity\User")
     * @ORM\JoinColumn(name="from_user_id", referencedColumnName="id")
     */
    private $fromUser;

    /**
     * @ORM\ManyToOne(targetEntity="BioprogrammeAccountBundle\Entity\User")
     * @ORM\JoinColumn(name="to_user_id", referencedColumnName="id")
     */
    private $toUser;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Email
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set isReaded
     *
     * @param boolean $isReaded
     *
     * @return Email
     */
    public function setIsReaded($isReaded)
    {
        $this->isReaded = $isReaded;

        return $this;
    }

    /**
     * Get isReaded
     *
     * @return bool
     */
    public function getIsReaded()
    {
        return $this->isReaded;
    }

    /**
     * Set From User
     *
     * @param User $user
     *
     * @return Notification
     */
    public function setFromUser(User $user)
    {
        $this->fromUser = $user;

        return $this;
    }

    /**
     * Get From User
     *
     * @return User
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * Set To User
     *
     * @param User $user
     *
     * @return Notification
     */
    public function setToUser(User $user)
    {
        $this->toUser = $user;

        return $this;
    }

    /**
     * Get To User
     *
     * @return User
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Email
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
     * @return Email
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

