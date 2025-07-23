<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Caves;
use App\Entity\Bouteilles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em): Response
    {
        $bouteillesCount = $em->getRepository(Bouteilles::class)->count([]);
        $usersCount = $em->getRepository(User::class)->count([]);
        $cavesCount = $em->getRepository(Caves::class)->count([]);
        $cepagesCount = $em->getRepository(Bouteilles::class)
            ->createQueryBuilder('b')
            ->select('COUNT(DISTINCT b.cepage)')
            ->getQuery()
            ->getSingleScalarResult();

        $latestCaves = $em->getRepository(Caves::class)
            ->findBy([], ['created_at' => 'DESC'], 4);

        return $this->render('home/index.html.twig', [
            'bouteillesCount' => $bouteillesCount,
            'usersCount' => $usersCount,
            'cavesCount' => $cavesCount,
            'cepagesCount' => $cepagesCount,
            'latestCaves' => $latestCaves,
        ]);
    }
}

