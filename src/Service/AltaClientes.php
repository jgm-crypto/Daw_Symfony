<?php

namespace App\Service;

use App\Entity\Usuarios;
use App\Entity\Cliente;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UsuarioRepository;
use App\Repository\ClienteRepository;
use Psr\Log\LoggerInterface;


class AltaClientes
{
    private $entityManager;
    private $usuarioRepository;
    private $clientesRepository;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, UsuarioRepository $usuarioRepository, ClienteRepository $clientesRepository, LoggerInterface $logger,)
    {
        $this->entityManager = $entityManager;
        $this->usuarioRepository = $usuarioRepository;
        $this->clientesRepository = $clientesRepository;
        $this->logger = $logger;
    }

    public function crearCuenta($data)
    {
        $usuario = new Usuarios();
        $usuario->setNombre($data["email"]);
        $usuario->setPassword($data["password"]);
        $this->entityManager->persist($usuario);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            // Manejar la excepción, por ejemplo, registrando el mensaje de error
            error_log($e->getMessage());
            // O podrías lanzar una excepción personalizada o devolver una respuesta HTTP con el error
        }

        $this->logger->info("Parametros: ", ["Datos" => $data]);

        $cliente = new Cliente();
        $cliente->setDni($data["dni"]);
        $cliente->setNombre($data["nombre"]);
        $cliente->setApellido($data["apellido"]);
        $cliente->setTelefono($data["tlf"]);
        $cliente->setEmail($data["email"]);
        $cliente->setUsuario($usuario);

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();
    }
}
