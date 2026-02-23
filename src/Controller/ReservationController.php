<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Spectacle;
use App\Entity\Utilisateur;
use App\Repository\SpectacleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/{id}', name: 'app_reservation', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function reserver(
        Spectacle $spectacle,
        Request $request,
        EntityManagerInterface $entityManager,
        SpectacleRepository $spectacleRepository
    ): Response {
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $nombrePlaces = (int) $request->request->get('nombre_places', 1);

            if ($nombrePlaces < 1 || $nombrePlaces > $spectacle->getPlacesDisponibles()) {
                $this->addFlash('error', $nombrePlaces < 1 
                    ? 'Le nombre de places doit être au moins 1.' 
                    : 'Il n\'y a pas assez de places disponibles.');
                return $this->redirectToRoute('app_reservation', ['id' => $spectacle->getId()]);
            }

            $prixUnitaire = (float) $spectacle->getPrix();
            $prixTotal = $prixUnitaire * $nombrePlaces;

            $reservation = (new Reservation())
                ->setUtilisateur($user)
                ->setSpectacle($spectacle)
                ->setNombrePlaces($nombrePlaces)
                ->setPrixUnitaire((string) $prixUnitaire)
                ->setPrixTotal((string) round($prixTotal, 2))
                ->setDateReservation(new \DateTime());

            $spectacle->setPlacesDisponibles($spectacle->getPlacesDisponibles() - $nombrePlaces);

            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_confirmation', ['id' => $reservation->getId()]);
        }

        return $this->render('reservation/reserver.html.twig', [
            'spectacle' => $spectacle,
            'tousLesSpectacles' => $spectacleRepository->findAll(),
        ]);
    }

    #[Route('/confirmation/{id}', name: 'app_reservation_confirmation')]
    #[IsGranted('ROLE_USER')]
    public function confirmation(Reservation $reservation): Response
    {
        if ($reservation->getUtilisateur()->getEmail() !== $this->getUser()->getEmail()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cette réservation.');
        }

        return $this->render('reservation/confirmation.html.twig', ['reservation' => $reservation]);
    }
}

