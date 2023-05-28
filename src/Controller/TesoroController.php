<?php

namespace App\Controller;

use App\Entity\Expedicion;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TesoroController extends AbstractController {


    #[Route('/tesoro/lista', name: 'tesoro_lista')]
    public function list(Request $request, LoggerInterface $logger) {
        $logger->info('probandoo.. 2');
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
                ],
                [
                    'id' => '3',
                    'title' => 'La capa'
                ]
            ]
        ]);
        return $response;
    }


    /**
     * @Route("/expedicion", name="create_expedicion")
     */
    public function createExpedicion(Request $request, EntityManagerInterface $em) {
        $response = new JsonResponse();
        $title = $request->get('title');
        
        if (empty($title)) {
            $response->setData([
                'sucess' => false,
                'error' => 'Title cannot be empty.',
                'data' => null
            ]);
            
            return $response;
        }
        
        $title = str_replace('-', ' ', $title);
        $title = ucfirst($title);

        $expedicion = new Expedicion();
        $expedicion->setTitulo($title);

        $em->persist($expedicion);
        $em->flush();

        $response->setData([
            'sucess' => true,
            'data' => [
                [
                    'id' => $expedicion->getId(),
                    'title' => $expedicion->getTitulo()
                ],
            ]
        ]);
        return $response;
    }
}
