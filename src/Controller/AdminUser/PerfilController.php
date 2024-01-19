<?php

namespace App\Controller\AdminUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use App\Repository\ClienteRepository;

class PerfilController extends AbstractController
{

    #[Route('/api/perfil', name: 'api_perfil', methods: ['GET', 'HEAD'])]
    public function __invoke(LoggerInterface $logger, ClienteRepository $clienteRepository)
    {
        $logger->info("Usuario -->> ");
        $user = $this->getUser();
        $cliente = $clienteRepository->findOneBy(["email" => $user->getUserIdentifier()]);

        $logger->info("Usuario -->> ", [" -->> " . var_export($user, true)]);

        return new JsonResponse([
            'Dni' => $cliente->getDni(),
            'Telefono' => $cliente->getTelefono()
        ]);
    }
}
