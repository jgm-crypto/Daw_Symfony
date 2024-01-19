<?php

namespace App\Controller\Public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NeumaticosRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class NeumaticosController extends AbstractController
{

    #[Route('/master', name: 'master', methods: ['GET', 'HEAD'])]
    public function getAllNeumaticosController(NeumaticosRepository $neumaticosRepository, LoggerInterface $logger): JsonResponse
    {

        $logger->info('Peticion todos neumaticos');

        $neumaticos = $neumaticosRepository->getAllNeumaticos();
        $res = new JsonResponse($neumaticos);

        return $res;
    }

    #[Route('/marcas', name: 'marcas', methods: ['GET', 'HEAD'])]
    public function getMarcasController(NeumaticosRepository $neumaticosRepository): JsonResponse
    {
        $marcas = $neumaticosRepository->getAllMarcas();
        $res = new JsonResponse($marcas);

        return $res;
    }

    #[Route('/neumatico/{marca}', name: 'neumatico', defaults: ['marca' => 'Michelin'], methods: ['GET', 'HEAD'])]
    public function getNeuByMarcaController(string $marca, NeumaticosRepository $neumaticosRepository, LoggerInterface $logger): Response
    {
        $neumaticos = $neumaticosRepository->getNeuByMarca($marca);
        $res = new JsonResponse($neumaticos);

        $logger->info('Result-->>' . print_r($res, true));

        return $res;
    }

    #[Route('/test/', name: 'test', defaults: ['tipo' => '1', 'calidad' => '4'], methods: ['GET', 'HEAD'])]
    public function getNeuByParamsController(Request $request, NeumaticosRepository $neumaticosRepository, LoggerInterface $logger): Response
    {

        $medida = $request->query->get('medida');
        $calidad = $request->query->get('calidad');
        $tipo = $request->query->get('tipo');

        $logger->info("Parametros ************************ -->>", ["Medida" => $medida, "Tipo" => $tipo, "Calidad" => $calidad]);

        $ancho = substr($medida, 0, strpos($medida, '/'));
        $perfil = substr($medida, strpos($medida, '/') + 1, 2);
        $diametro = substr($medida, strpos($medida, '/') + 3, 2);

        $carga = '';
        $cvelocidad = '';


        $logger->info($ancho . ' ' . $perfil . ' ' . $diametro);

        $neumaticos = $neumaticosRepository->getNeuByParams($ancho, $perfil, $diametro, $tipo, $calidad, $carga, $cvelocidad);
        $res = new JsonResponse($neumaticos);

        return $res;
    }

    #[Route('/insertNeumatico', name: 'insertNeumatico', methods: ['POST', 'HEAD'])]
    public function insertNeumaticosController(Request $request, NeumaticosRepository $neumaticosRepository, LoggerInterface $logger): Response
    {

        $data = json_decode($request->getContent(), true);

        // Asegúrate de que $data no es null antes de intentar loguearlo
        if ($data !== null) {
            $logger->info("Datos recibidos: ", ['data' => $data]);
        } else {
            $logger->error("JSON recibido es null o no es un formato válido.");
        }

        try {
            // Aquí es donde realizarías la operación de inserción utilizando el repositorio.
            // Por ejemplo:

            $neumaticosRepository->saveNeumaticos($data);
            // Suponiendo que la función insert devuelva true si la inserción fue exitosa.

            // Si todo va bien, puedes retornar una respuesta de éxito.
            return new JsonResponse(['success' => 'Neumático insertado correctamente'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // Si hay un error en la inserción, captura la excepción y devuelve un mensaje de error.
            $logger->error('Error al procesar los datos: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Error al procesar los datos'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
