<?php

namespace App\Controller;

use App\Entity\Bouteilles;
use App\Form\AddBouteillesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AddBouteillesController extends AbstractController
{
    #[Route('/add/bouteilles', name: 'add_bouteilles')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bouteille = new Bouteilles();
        $form = $this->createForm(AddBouteillesType::class, $bouteille);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bouteille);
            $entityManager->flush();

            $this->addFlash('success', 'Bouteille ajoutée avec succès !');
            return $this->redirectToRoute('bouteilles');
        }

        return $this->render('add_bouteilles/add_bouteilles.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
