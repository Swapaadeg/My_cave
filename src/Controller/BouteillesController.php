<?php

namespace App\Controller;

use App\Form\BouteillesFilterType;
use App\Repository\RegionRepository;
use App\Repository\BouteillesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class BouteillesController extends AbstractController
{
    #[Route('/bouteilles', name: 'bouteilles')]
    public function index(Request $request, PaginatorInterface $paginator, BouteillesRepository $vinRepository): Response
    {
        // Création et traitement du formulaire de filtres
        $form = $this->createForm(BouteillesFilterType::class);
        $form->handleRequest($request);
        $filters = $form->getData() ?? [];

        \dump('Filters:', $filters); // Ajoute ceci pour voir les valeurs reçues

        // On récupère un QueryBuilder avec les filtres
        $queryBuilder = $vinRepository->getFilteredQueryBuilder($filters);

        // Pagination
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('bouteilles/bouteilles.html.twig', [
            'bouteilles' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/get-regions', name: 'get_regions', methods: ['GET'])]
    public function getRegions(Request $request, RegionRepository $regionRepository): JsonResponse
    {
        $paysId = $request->query->get('paysId');

        if (!$paysId) {
            return new JsonResponse(['regions' => []]);
        }

        $regions = $regionRepository->findBy(['pays' => $paysId]);

        $data = [];
        foreach ($regions as $region) {
            $data[] = [
                'id' => $region->getId(),
                'nom' => $region->getNom()
            ];
        }

        return new JsonResponse(['regions' => $data]);
    }
}
