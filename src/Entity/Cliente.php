<?php

namespace App\Entity;

use App\Entity\Usuarios;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity
 */
class Cliente
{
    /**
     * @var string
     *
     * @ORM\Column(name="DNI", type="string", length=20, nullable=false)
     * @ORM\Id
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=20, nullable=false)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido", type="string", length=20, nullable=true)
     */
    private $apellido;

    /**
     * @var int|null
     *
     * @ORM\Column(name="telefono", type="integer", nullable=true)
     */
    private $telefono;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CP", type="integer", nullable=true)
     */
    private $cp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="direccion", type="string", length=40, nullable=true)
     */
    private $direccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Email", type="string", length=30, nullable=true)
     */
    private $email;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Usuarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="Id")
     */
    private $usuario;

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;
        return $this;
    }

    // Getter y setter para nombre
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    // Getter y setter para apellido
    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self
    {
        $this->apellido = $apellido;
        return $this;
    }

    // Getter y setter para telefono
    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(?int $telefono): self
    {
        $this->telefono = $telefono;
        return $this;
    }

    // Getter y setter para cp
    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(?int $cp): self
    {
        $this->cp = $cp;
        return $this;
    }

    // Getter y setter para direccion
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;
        return $this;
    }

    // Getter y setter para email
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }


    /*
    La función setUsuario en la entidad Cliente establece la asociación entre el cliente y el usuario. 
    Cuando persistes y haces flush en la entidad Cliente, 
    Doctrine automáticamente establecerá la clave foránea usuario_id en la tabla clientes con el ID del Usuario que acabas de guardar.
    */
    public function setUsuario(Usuarios $usuario): self
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getUsuario(): ?int
    {
        return $this->usuario ? $this->usuario->getId() : null;
    }
}
