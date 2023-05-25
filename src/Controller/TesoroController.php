<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TesoroController extends AbstractController {

    #[Route('tesoro/lista', name: 'tesoro_lista')]
    function list() {
        $response = new JsonResponse();
        $response->setData([
            'sucess' => true,
            'data' => [
                [
                    'id' => '1',
                    'title' => 'La medalla'
                ],
                [
                    'id' => '2',
                    'title' => 'La espada'
                ]
            ]
        ]);
        return $response;
    }
}
