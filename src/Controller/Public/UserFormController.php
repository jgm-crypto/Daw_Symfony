<?php

namespace App\Controller\Public;

use App\Service\AltaClientes;
use App\Entity\Usuarios;
use App\Form\Type\AltaClientesType;
use App\Form\Model\AltaClientesModel;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;


class UserFormController extends AbstractController
{

    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/saveCliente', name: 'saveCliente', methods: ['POST', 'HEAD'])]
    public function submitForm(
        AltaClientes $altaClientes,
        Request $request,
        LoggerInterface $logger,
        ValidatorInterface $validator,
        FormFactoryInterface $formFactory
    ): Response {
        // Decodificar JSON
        $data = json_decode($request->getContent(), true);

        $logger->info("Parametros: ", ["Datos" => $data]);

        // Validación de datos usando Validator Component
        $constraints = new Assert\Collection([
            'dni' => new Assert\Length(['min' => 8]),
            'nombre' => new Assert\NotBlank(),
            'apellido' => new Assert\NotBlank(),
            'email' => new Assert\Email(),
            'tlf' => new Assert\Regex('/^[67][0-9]{8}$/'), // Ejemplo de patrón para teléfonos en España
            'password' => new Assert\Length(['min' => 6])
        ]);

        $errors = $validator->validate($data, $constraints);

        // Manejo de errores de validación
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                // Aquí se pueden personalizar los mensajes de error
                $logger->info("Msg: ", ["error" => $error->getMessage()]);
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            // Construyendo un payload personalizado
            $payload = [
                'status' => 'error',
                'errors' => $errorMessages
            ];

            return $this->json($payload, Response::HTTP_BAD_REQUEST);
        }


        // Crear y procesar el formulario
        $userModel = new AltaClientesModel(); // Asegúrate de que esta clase corresponda con tu DTO

        // Crear el formulario con el tipo de formulario y modelo DTO correctos
        $form = $formFactory->create(AltaClientesType::class, $userModel);

        // Pasar manualmente los datos decodificados al formulario
        $form->submit($data);

        $logger->info('Form submitted: ' . ($form->isSubmitted() ? 'Yes' : 'No'));
        $logger->info('Form valid: ' . ($form->isValid() ? 'Yes' : 'No'));

        if ($form->isSubmitted() && $form->isValid()) {

            $usuario = new Usuarios();
            $encodedPassword = $this->passwordEncoder->hashPassword($usuario, $data['password']);

            $data["password"] = $encodedPassword;

            try {
                $altaClientes->crearCuenta($data);

                return new JsonResponse(['success' => 'Cliente insertado correctamente'], Response::HTTP_OK);
            } catch (\Exception $e) {
                // Si hay un error en la inserción, captura la excepción y devuelve un mensaje de error.
                $logger->error('Error al procesar los datos: ' . $e->getMessage());
                return new JsonResponse(['error' => 'Error al procesar los datos'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Log de depuración en ambiente de desarrollo
            $logger->info('Formulario enviado con éxito: ', $data);

            return $this->json(['message' => 'Formulario enviado con éxito']);
        }

        // Devolver errores de validación del formulario
        return $this->json(['errors' => (string)$form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
    }
}
