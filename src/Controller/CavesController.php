<?php

namespace App\Controller;

use App\Repository\CavesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CavesController extends AbstractController
{
    #[Route('/caves', name: 'caves')]
    public function index(CavesRepository $cavesRepository): Response
    {
        // On récupère toutes les caves (à trier si besoin)
        $caves = $cavesRepository->findBy([], ['created_at' => 'DESC']);

        return $this->render('caves/caves.html.twig', [
            'caves' => $caves,
        ]);
    }
}
