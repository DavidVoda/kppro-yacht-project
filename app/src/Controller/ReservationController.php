<?php

namespace App\Controller;

use App\Domain\Reservation\ReservationDisabledDays;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\YachtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ReservationController extends AbstractController
{

    public function __construct(
        private YachtRepository $yachtRepository,
        private ReservationRepository $reservationRepository,
        private ReservationDisabledDays $reservationDisabledDays
    ) {
    }

    #[Route('/reservation', name: 'reservation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/yacht/{id}/reserve', name: 'reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, string $id): Response
    {
        $yacht = $this->yachtRepository->get(Uuid::fromString($id));

        $reservation = new Reservation();
        $reservation->setYacht($yacht);

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setId(Uuid::uuid4());
            $reservation->setUser($this->getUser());
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        $disabledReservationDates = [];

        foreach ($this->reservationRepository->getByYacht(Uuid::fromString($id)) as $bookedReservation) {
            $disabledReservationDates = [
                ...$disabledReservationDates,
                ...$this->reservationDisabledDays->getDisabledDates($bookedReservation)
            ];
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'disabledDates' => json_encode($disabledReservationDates, JSON_THROW_ON_ERROR)
        ]);
    }

    #[Route('/reservation/{id}', name: 'reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/reservation/{id}/edit', name: 'reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // TODO: Normal users should only be able to delete their reservations only.

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/reservation/{id}', name: 'reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
