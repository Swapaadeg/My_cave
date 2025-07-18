<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BouteillesController extends AbstractController
{
    #[Route('/bouteilles', name: 'bouteilles')]
    public function index(): Response
    {
        return $this->render('bouteilles/bouteilles.html.twig', [
            'controller_name' => 'BouteillesController',
        ]);
    }
}
