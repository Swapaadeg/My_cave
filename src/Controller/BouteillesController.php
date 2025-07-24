<?php

namespace App\Controller;

use App\Form\BouteillesFilterType;
use App\Repository\BouteillesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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
}
