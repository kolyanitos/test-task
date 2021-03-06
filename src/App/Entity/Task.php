<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity(repositoryClass="App\Repository\TaskRepository")
 * @Table(name="tasks")
 **/
class Task {
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     **/
    protected $id;

    /**
     * @var null|User $user
     *
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     **/
    protected $user;

    /**
     * @Column(type="string")
     * @var string
     **/
    protected $username;

    /**
     * @Column(type="string")
     * @var string
     **/
    protected $email;

    /**
     * @Column(type="text", length=2048)
     * @var string
     **/
    protected $description;

    /**
     * @Column(type="boolean", options={"default": false})
     * @var bool
     **/
    protected $isDone = false;

    /**
     * @Column(type="string")
     * @var string
     **/
    protected $image = '';

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Task
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Task
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
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
     * Set isDone
     *
     * @param boolean $isDone
     * @return Task
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;

        return $this;
    }

    /**
     * Get isDone
     *
     * @return boolean 
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Task
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
     * Set user
     *
     * @param \App\Entity\User $user
     * @return Task
     */
    public function setUser(\App\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
