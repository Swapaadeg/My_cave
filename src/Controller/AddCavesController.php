<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddCavesController extends AbstractController
{
    #[Route('/add/caves', name: 'add_caves')]
    public function index(): Response
    {
        return $this->render('add_caves/add_caves.html.twig', [
            'controller_name' => 'AddCavesController',
        ]);
    }
}
