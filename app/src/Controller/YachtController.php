<?php

namespace App\Controller;

use App\Domain\Yacht\YachtImageAssigner;
use App\Entity\Review;
use App\Entity\User;
use App\Entity\Yacht;
use App\Form\YachtType;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/yacht')]
class YachtController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private YachtImageAssigner $assigner
    ) {
    }

    #[Route('/', name: 'yacht_index', methods: ['GET'])]
    public function index(): Response
    {
        $yachts = $this->entityManager->getRepository(Yacht::class)->findAll();

        return $this->render('yacht/index.html.twig', [
            'yachts' => $yachts,
        ]);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/new', name: 'yacht_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $yacht = new Yacht();
        $form = $this->createForm(YachtType::class, $yacht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yacht->setId(Uuid::uuid4());
            $image = $form->get('image')->getData();

            if ($image) {
                $this->assigner->assign($yacht, $image);
                $this->entityManager->flush();
            }
            $this->entityManager->persist($yacht);
            $this->entityManager->flush();

            return $this->redirectToRoute('yacht_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('yacht/new.html.twig', [
            'yacht' => $yacht,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'yacht_show', methods: ['GET'])]
    public function show(Yacht $yacht): Response
    {
        $reviews = $this->entityManager
            ->getRepository(Review::class)
            ->findBy(['yacht' => $yacht]);

        return $this->render('yacht/show.html.twig', [
            'yacht' => $yacht,
            'reviews' => $reviews,
        ]);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/{id}/edit', name: 'yacht_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Yacht $yacht): Response
    {
        $form = $this->createForm(YachtType::class, $yacht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('upload')->isClicked()) {
                $image = $form->get('image')->getData();

                if ($image) {
                    $this->assigner->assign($yacht, $image);
                    $this->entityManager->flush();
                }

                return $this->renderForm('yacht/edit.html.twig', [
                    'yacht' => $yacht,
                    'form' => $form,
                ]);
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('yacht_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('yacht/edit.html.twig', [
            'yacht' => $yacht,
            'form' => $form,
        ]);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/{id}', name: 'yacht_delete', methods: ['POST'])]
    public function delete(Request $request, Yacht $yacht): Response
    {
        if ($this->isCsrfTokenValid('delete' . $yacht->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($yacht);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('yacht_index', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted(User::ROLE_ADMIN)]
    #[Route('/{id}/delete-image/{imageIndex}', name: 'yacht_delete_image', methods: ['GET'])]
    public function deleteImage(Yacht $yacht, int $imageIndex): Response
    {
        $this->assigner->unassign($yacht, $imageIndex);

        $this->entityManager->flush();

        return $this->redirectToRoute('yacht_edit', ['id' => $yacht->getId()], Response::HTTP_SEE_OTHER);
    }
}
