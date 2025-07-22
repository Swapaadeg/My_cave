<?php

namespace App\Controller;

use App\Entity\Caves;
use App\Form\AddCavesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CavePersoController extends AbstractController
{
    #[Route('/cave/perso', name: 'cave_perso')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $cave = $em->getRepository(Caves::class)->findOneBy(['cave' => $user]);

        if (!$cave) {
            $cave = new Caves();
            $form = $this->createForm(AddCavesType::class, $cave);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {
                $cave->setCave($user);
                $cave->setCreatedAt(new \DateTimeImmutable());
                // Ajoute ceci pour forcer la modification
                $cave->setUpdatedAt(new \DateTimeImmutable());
                $em->persist($cave);
                $em->flush();
                $this->addFlash('success', 'Votre cave a été créée !');
                return $this->redirectToRoute('cave_perso');
            }
            
            return $this->render('cave_perso/add_caves.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        
        dump($cave);
        return $this->render('cave_perso/cave_perso.html.twig', [
            'cave' => $cave,
            'bouteilles' => $cave->getCavesBouteilles(),
        ]);
    }

}
