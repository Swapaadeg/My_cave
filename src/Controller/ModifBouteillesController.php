<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ModifBouteillesController extends AbstractController
{
    #[Route('/modif/bouteilles', name: 'modif_bouteilles')]
    public function index(): Response
    {
        return $this->render('modif_bouteilles/modif_bouteilles.html.twig', [
            'controller_name' => 'ModifBouteillesController',
        ]);
    }
}
