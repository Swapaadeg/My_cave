<?php
namespace App\Controller;

use App\Entity\Caves;
use App\Entity\Bouteilles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CaveAddBouteillesController extends AbstractController
{
    #[Route('/cave/ajouter/{id}', name: 'cave-add-bouteilles', methods: ['POST'])]
    public function ajouterBouteille(Bouteilles $bouteille, EntityManagerInterface $em, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }
        
        $token = $request->request->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('ajout_cave_' . $bouteille->getId(), $token))) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }
        $cave = $em->getRepository(Caves::class)->findOneBy(['cave' => $user]);

        if (!$cave) {
            $cave = new Caves();
            $cave->setNom('Ma cave')
                 ->setDescription('Cave par défaut')
                 ->setCave($user)
                 ->setCreatedAt(new \DateTimeImmutable());
            $em->persist($cave);
        }


        // Vérifier si la bouteille existe déjà dans la cave
        $caveBouteille = $em->getRepository(\App\Entity\CaveBouteille::class)
            ->findOneBy(['cave' => $cave, 'bouteille' => $bouteille]);
        if (!$caveBouteille) {
            $caveBouteille = new \App\Entity\CaveBouteille();
            $caveBouteille->setCave($cave);
            $caveBouteille->setBouteille($bouteille);
            $caveBouteille->setQuantite(1);
            $em->persist($caveBouteille);
        } else {
            $caveBouteille->setQuantite($caveBouteille->getQuantite() + 1);
        }

        $em->flush();

        $this->addFlash('success', 'La bouteille a bien été ajoutée à votre cave !');
        return $this->redirectToRoute('bouteilles');
    }

    #[Route('/cave/retirer/{id}', name: 'cave-remove-bouteilles', methods: ['POST'])]
    public function retirerBouteille(Bouteilles $bouteille, EntityManagerInterface $em, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }
        $token = $request->request->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('retrait_cave_' . $bouteille->getId(), $token))) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }
        $cave = $em->getRepository(Caves::class)->findOneBy(['cave' => $user]);
        if ($cave) {
            $caveBouteille = $em->getRepository(\App\Entity\CaveBouteille::class)
                ->findOneBy(['cave' => $cave, 'bouteille' => $bouteille]);
            if ($caveBouteille) {
                $em->remove($caveBouteille);
                $em->flush();
                $this->addFlash('success', 'La bouteille a bien été retirée de votre cave !');
            }
        }
        return $this->redirectToRoute('cave_perso');
    }

    #[Route('/cave/increment/{id}', name: 'cave_increment_bouteille', methods: ['POST'])]
    public function incrementBouteille(int $id, EntityManagerInterface $em, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }
        $caveBouteille = $em->getRepository(\App\Entity\CaveBouteille::class)->find($id);
        if (!$caveBouteille || $caveBouteille->getCave()->getCave() !== $user) {
            throw $this->createAccessDeniedException();
        }
        $token = $request->request->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('increment_' . $caveBouteille->getId(), $token))) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }
        $caveBouteille->setQuantite($caveBouteille->getQuantite() + 1);
        $em->flush();
        return $this->json([
            'success' => true,
            'quantite' => $caveBouteille->getQuantite(),
        ]);
    }

    #[Route('/cave/decrement/{id}', name: 'cave_decrement_bouteille', methods: ['POST'])]
    public function decrementBouteille(int $id, EntityManagerInterface $em, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }
        $caveBouteille = $em->getRepository(\App\Entity\CaveBouteille::class)->find($id);
        if (!$caveBouteille || $caveBouteille->getCave()->getCave() !== $user) {
            throw $this->createAccessDeniedException();
        }
        $token = $request->request->get('_token');
        if (!$csrfTokenManager->isTokenValid(new CsrfToken('decrement_' . $caveBouteille->getId(), $token))) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }
        if ($caveBouteille->getQuantite() > 1) {
            $caveBouteille->setQuantite($caveBouteille->getQuantite() - 1);
            $em->flush();
        }
        return $this->json([
            'success' => true,
            'quantite' => $caveBouteille->getQuantite(),
        ]);
    }
}
