<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ModifCavesController extends AbstractController
{
    #[Route('/modif/caves', name: 'modif_caves')]
    public function index(): Response
    {
        return $this->render('modif_caves/modif_caves.html.twig', [
            'controller_name' => 'ModifCavesController',
        ]);
    }
}
