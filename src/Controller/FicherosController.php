<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;


class FicherosController extends AbstractController
{

    #[Route('/getTexto/{nombre}', name: 'getTexto', methods: ['GET', 'HEAD'])]
    public function getArchivoTexto(string $nombre, LoggerInterface $logger): Response
    {

        $logger->info('Parametro-->>' . $nombre);

        // Asegúrate de que la ruta al archivo sea la correcta
        $rutaArchivo = $this->getParameter('kernel.project_dir') . '/public/txt/' . $nombre . '.txt';

        try {
            // Leer el contenido del archivo
            $contenido = file_get_contents($rutaArchivo);

            // Verifica si el archivo realmente se leyó
            if ($contenido === false) {
                throw new \Exception('No se pudo leer el archivo');
            }

            // Devolver el contenido como una respuesta con tipo de contenido text/plain o text/html
            return new Response($contenido, 200, ['Content-Type' => 'text/plain']);
        } catch (\Exception $e) {
            // Si hay un error, puedes optar por manejarlo como creas conveniente
            return new Response('Error al leer el archivo: ' . $e->getMessage(), 500);
        }
    }
}
