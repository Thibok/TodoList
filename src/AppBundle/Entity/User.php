<?php
declare(strict_types=1);

/**
 * User (Entity)
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @var int
     * @access private
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @access private
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private $username;

    /**
     * @var string
     * @access private
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var string
     * @access private
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private $email;

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
     * {@inheritDoc}
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set username
     * @access public
     * @param string $username
     * 
     * @return User
     */
    public function setUsername($username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set password
     * @access public
     * @param string $password
     * 
     * @return User
     */
    public function setPassword($password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get email
     * @access public
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email
     * @access public
     * @param string $email
     * 
     * @return User
     */
    public function setEmail($email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(): array
    {
        return array('ROLE_USER');
    }

    /**
     * {@inheritDoc}
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials(): void
    {
    }
}
