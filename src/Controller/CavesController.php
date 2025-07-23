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
        $caves = $cavesRepository->findAll();

        return $this->render('caves/caves.html.twig', [
            'caves' => $caves,
        ]);
    }
}
