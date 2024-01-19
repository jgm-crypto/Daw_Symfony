<?php
// src/Controller/EnvironmentController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EnvironmentController extends AbstractController
{
    /**
     * @Route("/api/public-key", name="app_public_key")
     */
    public function publicKey(): JsonResponse
    {
        // Utiliza getParameter para obtener la ruta del directorio del proyecto
        $projectDir = $this->getParameter('kernel.project_dir');

        // Construye la ruta completa al archivo de la clave pública
        $publicKeyPath = $projectDir . '/config/jwt/public.pem';

        // Verifica si el archivo existe y es legible
        if (!is_readable($publicKeyPath)) {
            throw $this->createNotFoundException('Public key file not found or not readable.');
        }

        // Lee el contenido del archivo
        $publicKeyContent = file_get_contents($publicKeyPath);

        // Devuelve la clave pública como una respuesta JSON
        return new JsonResponse(['public_key' => $publicKeyContent]);
    }
}
