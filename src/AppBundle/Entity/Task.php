<?php
declare(strict_types=1);

/**
 * Task (Entity)
 */

namespace AppBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Task
 * 
 * @ORM\Table(name="tdl_task")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 */
class Task
{
    /**
     * @var int
     */
    const TASK_PER_PAGE = 10;
    
    /**
     * @var int
     * @access private
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @access private
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="title", type="string", length=60)
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     * @Assert\Length(
     *      min=2,
     *      minMessage="Le titre doit etre de 2 caractères minimum.",
     *      max=50,
     *      maxMessage="Le titre doit etre de 50 caractères maximum."
     * )
     * @Assert\Regex(
     *      pattern="/^([a-zA-Z0-9]+ ?[a-zA-Z0-9]+)+$/",
     *      message="Le titre ne peut contenir ques des lettres, des chiffres et des espaces."
     * )
     */
    private $title;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     * @Assert\Length(
     *      max=500,
     *      maxMessage="Le contenu doit etre de 500 caractères maximum."
     * )
     * @Assert\Regex(
     *      pattern="/[<>]/",
     *      match=false,
     *      message="Le contenu ne doit pas contenir de < ou >"
     * )
     */
    private $content;
    
    /**
     * @var boolean
     * @access private
     * @ORM\Column(name="isDone", type="boolean")
     */
    private $isDone;

    /**
     * @var User
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * Constructor
     * @access public
     * 
     * @return void
     */
    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->isDone = false;
    }

    /**
     * Get id
     * @access public
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get createdAt
     * @access public
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     * @access public
     * @param \DateTime $createdAt
     * 
     * @return Task
     */
    public function setCreatedAt($createdAt): Task
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get title
     * @access public
     *
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set title
     * @access public
     * @param string $title
     * 
     * @return Task
     */
    public function setTitle($title): Task
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get content
     * @access public
     * 
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set content
     * @access public
     * @param string $content
     * 
     * @return Task
     */
    public function setContent($content): Task
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Check task is done
     * @access public
     * 
     * @return boolean
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * Toggle task
     * @access public
     * @param boolean $flag
     * 
     * @return void
     */
    public function toggle($flag): void
    {
        $this->isDone = $flag;
    }

    /**
     * Set user
     * @access public
     * @param User|null $user
     *
     * @return Task
     */
    public function setUser(User $user = null): Task
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     * @access public
     * 
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
