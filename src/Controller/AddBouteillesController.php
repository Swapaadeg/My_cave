<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddBouteillesController extends AbstractController
{
    #[Route('/add/bouteilles', name: 'add_bouteilles')]
    public function index(): Response
    {
        return $this->render('add_bouteilles/add_bouteilles.html.twig', [
            'controller_name' => 'AddBouteillesController',
        ]);
    }
}
