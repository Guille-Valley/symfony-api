<?php

namespace App\Controller;

use App\Entity\Expedicion;
use App\Repository\ExpedicionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TesoroController extends AbstractController {


    #[Route('/tesoros', name: 'tesoros')]
    public function list(Request $request, ExpedicionRepository $expedicionRepository) {
       
       $expediciones = $expedicionRepository->findAll();

        foreach($expediciones as $expedicion ){
            $expedicionASArray[] = [
                'id' => $expedicion->getId(),
                'title' => $expedicion->getTitulo(),
            ];
        }

        $response = new JsonResponse();
        $response->setData([
            'sucess' => true,
            'data' => $expedicionASArray,
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
