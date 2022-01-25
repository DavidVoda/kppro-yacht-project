<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewType;
use App\Repository\YachtRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReviewController extends AbstractController
{
    public function __construct(
        private YachtRepository $yachtRepository,
    )
    {
    }

    #[Route('/review', name: 'review_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reviews = $entityManager
            ->getRepository(Review::class)
            ->findAll();

        return $this->render('review/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('/yacht/{id}/review', name: 'review_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, string $id): Response
    {
        $yacht = $this->yachtRepository->get(Uuid::fromString($id));

        $review = new Review();
        $review->setYacht($yacht);

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $review->setId(Uuid::uuid4());
            $review->setUser($this->getUser());
            $review->setCreateDate(DateTimeImmutable::createFromFormat(
                DateTimeInterface::RFC3339_EXTENDED,
                date('Y-m-d\TH:i:s.vP')
            ));
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('yacht_show', array('id' => $yacht -> getId()), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('review/new.html.twig', [
            'review' => $review,
            'form' => $form,
        ]);
    }

    #[Route('/review/{id}', name: 'review_show', methods: ['GET'])]
    public function show(Review $review): Response
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
        ]);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/review/{id}/edit', name: 'review_edit', methods: ['GET', 'POST'])]
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
    #[Route('/review/{id}', name: 'review_delete', methods: ['POST'])]
    public function delete(Request $request, Review $review, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $review->getId(), $request->request->get('_token'))) {
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('review_index', [], Response::HTTP_SEE_OTHER);
    }
}
