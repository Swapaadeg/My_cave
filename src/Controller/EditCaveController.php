<?php

namespace App\Controller;

use App\Entity\Caves;
use App\Form\EditCaveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EditCaveController extends AbstractController
{
    #[Route('/cave/edition', name: 'edit_cave')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $cave = $em->getRepository(Caves::class)->findOneBy(['cave' => $user]);

        if (!$cave) {
            throw $this->createNotFoundException("Aucune cave à modifier.");
        }

        $form = $this->createForm(EditCaveType::class, $cave);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Cave mise à jour !');
            return $this->redirectToRoute('cave_perso');
        }

        return $this->render('cave_perso/edit_cave.html.twig', [
            'form' => $form->createView(),
            'cave' => $cave,
        ]);
    }
}