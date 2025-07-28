<?php

namespace App\Controller;

use App\Entity\Caves;
use App\Entity\CommentairesCaves;
use App\Form\AddCavesType;
use App\Form\CommentairesCavesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CavePersoController extends AbstractController
{
    //MA CAVE PERSO 
    #[Route('/cave/perso', name: 'cave_perso')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $cave = $em->getRepository(Caves::class)->findOneBy(['cave' => $user]);

        // Si l'utilisateur n'a pas encore de cave, on affiche le formulaire pour la créer
        if (!$cave) {
            $cave = new Caves();
            $form = $this->createForm(AddCavesType::class, $cave);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $cave->setCave($user);
                $cave->setCreatedAt(new \DateTimeImmutable());
                $cave->setUpdatedAt(new \DateTimeImmutable());

                $em->persist($cave);
                $em->flush();

                $this->addFlash('success', 'Votre cave a bien été créée !');
                return $this->redirectToRoute('cave_perso');
            }

            return $this->render('cave_perso/add_caves.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $result = $this->handleCommentaires($request, $em, $cave);
        if (!empty($result['redirect'])) {
            return $this->redirectToRoute('cave_perso');
        }

        return $this->render('cave_perso/cave_perso.html.twig', [
            'cave' => $cave,
            'bouteilles' => $cave->getCaveBouteilles(),
            'form_commentaire' => $result['form_commentaire']->createView(),
            'form_reponse' => $result['form_reponse']->createView(),
        ]);
    }

    // AFFICHAGE D’UNE CAVE PUBLIQUE
    #[Route('/cave/{id}', name: 'cave_afficher', requirements: ['id' => '\d+'])]
    public function afficher(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $cave = $em->getRepository(Caves::class)->find($id);

        if (!$cave) {
            throw $this->createNotFoundException("Cave introuvable.");
        }

        $result = $this->handleCommentaires($request, $em, $cave);
        if (!empty($result['redirect'])) {
            return $this->redirectToRoute('cave_afficher', ['id' => $id]);
        }

        return $this->render('cave_perso/cave_perso.html.twig', [
            'cave' => $cave,
            'bouteilles' => $cave->getCaveBouteilles(),
            'form_commentaire' => $result['form_commentaire']->createView(),
            'form_reponse' => $result['form_reponse']->createView(),
        ]);
    }

    // REPONDRE À UN COMMENTAIRE
    #[Route('/cave/{caveId}/repondre/{id}', name: 'repondre_commentaire', methods: ['POST'])]
    public function repondreCommentaire(
        int $caveId,
        CommentairesCaves $commentaireParent,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        $cave = $em->getRepository(Caves::class)->find($caveId);
        if (!$cave) {
            throw $this->createNotFoundException("Cave introuvable.");
        }

        $reponse = new CommentairesCaves();
        $reponse->setUser($user);
        $reponse->setCave($cave);
        $reponse->setReponse($commentaireParent);
        $reponse->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(CommentairesCavesType::class, $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reponse);
            $em->flush();
            $this->addFlash('success', 'Réponse ajoutée.');
        }

        return $this->redirectToRoute('cave_afficher', ['id' => $caveId]);
    }

    // LOGIQUE MUTUALISÉE POUR COMMENTAIRES
    private function handleCommentaires(Request $request, EntityManagerInterface $em, Caves $cave): array
    {
        $user = $this->getUser();

        $commentaire = new CommentairesCaves();
        $commentaire->setUser($user);
        $commentaire->setCave($cave);
        $commentaire->setCreatedAt(new \DateTimeImmutable());

        $formCommentaire = $this->createForm(CommentairesCavesType::class, $commentaire);
        $formCommentaire->handleRequest($request);

        if ($formCommentaire->isSubmitted() && $formCommentaire->isValid()) {
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Commentaire ajouté.');
            return ['redirect' => true];
        }

        $formReponse = $this->createForm(CommentairesCavesType::class);

        return [
            'form_commentaire' => $formCommentaire,
            'form_reponse' => $formReponse,
        ];
    }
    // SUPPRIMER UN COMMENTAIRE
    #[Route('/commentaire/supprimer/{id}', name: 'supprimer_commentaire', methods: ['POST'])]
    public function supprimerCommentaire(
        CommentairesCaves $commentaire,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();

        if (!$user || $user !== $commentaire->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer ce commentaire.");
        }

        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('supprimer' . $commentaire->getId(), $submittedToken)) {
            $em->remove($commentaire);
            $em->flush();

            $this->addFlash('success', 'Commentaire supprimé.');
        }

        return $this->redirectToRoute('cave_afficher', [
            'id' => $commentaire->getCave()->getId(),
        ]);
    }
}
