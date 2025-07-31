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
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        BouteillesRepository $vinRepository
    ): Response {

        //creation formulaire
        $form = $this->createForm(BouteillesFilterType::class);
        //remplit le form avec les donnees de la requête
        $form->handleRequest($request);

        //on recup les données du form dans l'url
        $submittedData = $request->query->all()['bouteilles_filter'] ?? [];
        $filters = $this->normalizeFilters($form->getData() ?? [], $submittedData);
        $queryBuilder = $vinRepository->getFilteredQueryBuilder($filters);

        //pagination avec knp paginnator
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            12  // Nombre de bouteilles dans la page
        );

        return $this->render('bouteilles/bouteilles.html.twig', [
            'bouteilles' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    //Methode AJAX pour récupérer les régions en fonction du pays
    #[Route('/get-regions', name: 'get_regions', methods: ['GET'])]
    public function getRegions(Request $request, RegionRepository $regionRepository): JsonResponse
    {
        $paysId = $request->query->get('paysId');
        if (!$paysId || !is_numeric($paysId)) {
            return new JsonResponse(['regions' => []]);
        }
        $regions = $regionRepository->findBy(['pays' => $paysId]);
        $data = array_map(fn($region) => [
            'id' => $region->getId(),
            'nom' => $region->getNom()
        ], $regions);
        return new JsonResponse(['regions' => $data]);
    }

    //verification et conversion des filtres pour s'assurer qu'ils sont au bon format
    private function normalizeFilters(array $filters, array $submittedData): array
    {
        $mapInt = fn($v) => is_numeric($v) ? (int)$v : $v;
        // REGION
        if (empty($filters['region']) && isset($submittedData['region']) && is_numeric($submittedData['region'])) {
            $filters['region'] = (int)$submittedData['region'];
        }
        // TYPE
        if (empty($filters['type']) && isset($submittedData['type']) && is_array($submittedData['type'])) {
            $filters['type'] = array_map($mapInt, $submittedData['type']);
        }
        // CEPAGE
        if (empty($filters['cepage']) && isset($submittedData['cepage']) && is_numeric($submittedData['cepage'])) {
            $filters['cepage'] = (int)$submittedData['cepage'];
        }
        // PAYS
        if (empty($filters['pays']) && isset($submittedData['pays']) && is_numeric($submittedData['pays'])) {
            $filters['pays'] = (int)$submittedData['pays'];
        }
        return $filters;
    }
}
