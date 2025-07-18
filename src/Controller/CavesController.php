<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CavesController extends AbstractController
{
    #[Route('/caves', name: 'caves')]
    public function index(): Response
    {
        return $this->render('caves/caves.html.twig', [
            'controller_name' => 'CavesController',
        ]);
    }
}
