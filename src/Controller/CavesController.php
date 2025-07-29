<?php

namespace App\Controller;

use App\Repository\CavesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CavesController extends AbstractController
{
    #[Route('/caves', name: 'caves')]
    public function index(CavesRepository $cavesRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $cavesRepository->createQueryBuilder('c')
            ->orderBy('c.created_at', 'DESC')
            ->getQuery();

        $page = (int) $request->query->get('page', 1);
        $pagination = $paginator->paginate(
            $query,
            $page,
            10 // Nombre de caves dans la page (paginator!)
        );

        return $this->render('caves/caves.html.twig', [
            'caves' => $pagination,
        ]);
    }
}
