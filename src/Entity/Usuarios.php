<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios")
 * @ORM\Entity
 */
class Usuarios implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY") Esta anotacion se usa cuando el valor se genera automaticamente por la BBDD
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pass", type="text", nullable=true)
     */
    private $pass;


    public function getRoles(): array
    {
        return ['ROLE_USER'];
        // devuelve los roles del usuario
    }

    public function getSalt()
    {
        // puede devolver null si estás usando un algoritmo moderno
    }

    public function getUsername(): string
    {
        return $this->nombre;
    }

    public function eraseCredentials()
    {
        // limpia las credenciales sensibles
    }

    public function getUserIdentifier(): string
    {
        return $this->nombre;
        // devuelve el identificador único del usuario (por ejemplo, email)
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function setPassword(string $pass): self
    {
        $this->pass = $pass;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->pass;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
}
