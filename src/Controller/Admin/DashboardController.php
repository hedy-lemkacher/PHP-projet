<?php

namespace App\Controller\Admin;

use App\Entity\Spectacle;
use App\Entity\Utilisateur;
use App\Entity\Reservation;
use App\Controller\Admin\SpectacleCrudController;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    // On injecte l'EntityManager pour interroger la base de données
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // 1. Compter le nombre total de réservations
        $reservationsRepo = $this->entityManager->getRepository(Reservation::class);
        $countReservations = $reservationsRepo->count([]);

        // 2. Calculer le total des ventes
        // On joint la table 'Spectacle' pour récupérer le prix
        $queryBuilder = $reservationsRepo->createQueryBuilder('r')
            ->leftJoin('r.spectacle', 's') // 's' est l'alias pour Spectacle
            ->select('SUM(s.prix)');       // On additionne les prix des spectacles

        // NOTE : Si vous avez une quantité (ex: nbPlaces) dans la réservation,
        // remplacez la ligne du dessus par : ->select('SUM(s.prix * r.nbPlaces)');

        $totalRevenu = $queryBuilder->getQuery()->getSingleScalarResult();

        // Si c'est vide (null), on met 0 par défaut
        $totalRevenu = $totalRevenu ?? 0;

        // 3. Envoyer les données à la vue
        return $this->render('admin/dashboard.html.twig', [
            'countReservations' => $countReservations,
            'totalRevenu' => $totalRevenu
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Spektacles Admin')
            ->setFaviconPath('favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Spectacles', 'fas fa-theater-masks', Spectacle::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', Utilisateur::class);
        yield MenuItem::linkToCrud('Réservations', 'fas fa-ticket-alt', Reservation::class);

        yield MenuItem::section('Site');
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_home');
    }
}
