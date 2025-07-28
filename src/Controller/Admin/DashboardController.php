<?php

namespace App\Controller\Admin;

use App\Entity\Pays;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Caves;
use App\Entity\Cepage;
use App\Entity\Region;
use App\Entity\Bouteilles;
use App\Entity\CommentairesCaves;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[IsGranted('ROLE_ADMIN')]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function index(): Response
    {
        $bouteillesCount = $this->em->getRepository(\App\Entity\CaveBouteille::class)
            ->createQueryBuilder('cb')
            ->select('SUM(cb.quantite)')
            ->getQuery()
            ->getSingleScalarResult();
        $usersCount = $this->em->getRepository(User::class)->count([]);
        $cavesCount = $this->em->getRepository(Caves::class)->count([]);
        $commentairesCount = $this->em->getRepository(CommentairesCaves::class)->count([]);

        return $this->render('admin/index.html.twig', [
            'bouteillesCount' => $bouteillesCount,
            'usersCount' => $usersCount,
            'cavesCount' => $cavesCount,
            'commentairesCount' => $commentairesCount,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('My Cave');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Bouteilles', 'fa-solid fa-wine-bottle', Bouteilles::class); // bouteille
        yield MenuItem::linkToCrud('Caves', 'fa-solid fa-warehouse', Caves::class); // entrepôt/cave
        yield MenuItem::linkToCrud('Commentaires des Caves', 'fa-solid fa-comment-dots', CommentairesCaves::class); // commentaire
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', User::class); // utilisateur
        yield MenuItem::linkToCrud('Regions', 'fa-solid fa-mountain', Region::class); // montagne/région
        yield MenuItem::linkToCrud('Pays', 'fa-solid fa-flag', Pays::class); // drapeau/pays
        yield MenuItem::linkToCrud('Cépages', 'fa-solid fa-seedling', Cepage::class); // plant/vigne
        yield MenuItem::linkToCrud('Types', 'fa-solid fa-tags', Type::class); // étiquette/type
    }
}
