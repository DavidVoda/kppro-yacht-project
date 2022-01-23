<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\User;
use App\Entity\Yacht;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/review')]
class ReviewController extends AbstractController
{
    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/', name: 'review_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reviews = $entityManager
            ->getRepository(Review::class)
            ->findAll();

        return $this->render('review/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('/new', name: 'review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('review/new.html.twig', [
            'review' => $review,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'review_show', methods: ['GET'])]
    public function show(Review $review): Response
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
        ]);
    }

    #[Route('/{id}/edit', name: 'review_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('review_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('review/edit.html.twig', [
            'review' => $review,
            'form' => $form,
        ]);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/{id}', name: 'review_delete', methods: ['POST'])]
    public function delete(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('review_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/', name: 'review_yacht', methods: ['GET'])]
    public function getReviewsForYacht(EntityManagerInterface $entityManager, Yacht $yacht): Response
    {
        $reviews = $entityManager
            ->getRepository(Review::class)
            ->findBy(['yacht' => $yacht]);

        return $this->render('review/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }
}
