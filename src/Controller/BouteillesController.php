<?php

namespace App\Controller;

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
        $query = $vinRepository->createQueryBuilder('v')->getQuery();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), // page actuelle, par défaut 1
            20// nombre de bouteilles par page
        );

        return $this->render('bouteilles/bouteilles.html.twig', [
            'bouteilles' => $pagination,
        ]);
    }
}
