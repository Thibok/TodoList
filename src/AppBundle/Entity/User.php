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
 * User
 *
 * @ORM\Table(name="tdl_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Cette email est déjà utilisée")
 * @UniqueEntity(fields="username", message="Ce nom d'utilisateur est déjà utilisé")
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @var int
     */
    const USER_PER_PAGE = 10;

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
     * @ORM\Column(name="username", type="string", length=30, unique=true)
     * @Assert\NotBlank(message = "Vous devez saisir un nom d'utilisateur.")
     * @Assert\Length(
     *      min = 4,
     *      max = 30,
     *      minMessage = "Le nom d'utilisateur doit être de 4 caractères minimum.",
     *      maxMessage = "Le nom d'utilisateur doit être de 30 caractères maximum."
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z0-9_-]{4,}$/",
     *      message = "Le nom d'utilisateur peut contenir lettres, chiffres et tirets."
     * )
     */
    private $username;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="password", type="string", length=64)
     * @Assert\NotBlank(message = "Vous devez saisir un mot de passe.")
     * @Assert\Length(
     *      min = 8,
     *      max = 48,
     *      minMessage = "Le mot de passe doit être de 8 caractères minimum.",
     *      maxMessage = "Le mot de passe doit être de 48 caractères maximum."
     * )
     * @Assert\Regex(
     *      pattern = "/^(?=.*[0-9])(?=.*[a-zA-Z]).{8,}$/",
     *      message = "Le mot de passe doit contenir au moins une lettre et un chiffre."
     * )
     */
    private $password;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     * @Assert\NotBlank(message = "Vous devez saisir une adresse email.")
     * @Assert\Length(
     *      min = 7,
     *      max = 60,
     *      minMessage = "L'adresse email doit être de 7 caractères minimum.",
     *      maxMessage = "L'adresse email doit être de 60 caractères maximum."
     * )
     * @Assert\Email(message = "Merci d'entrer une adresse email valide.")
     */
    private $email;

    /**
     * @var array
     * @access private
     * @ORM\Column(name="role", type="string", length=20)
     * @Assert\NotBlank(message="Vous devez choisir un rôle.")
     */
    private $role;

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
    public function getRoles(): ?array
    {
        return [$this->role];
    }

    /**
     * Get role
     * @access public
     * 
     * @return string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Set role
     * @access public
     * @param string role
     * 
     * @return User
     */
    public function setRole($role): User
    {
        $this->role = $role;

        return $this;
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
