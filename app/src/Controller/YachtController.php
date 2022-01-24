<?php

namespace App\Controller;

use App\Domain\Yacht\YachtImageAssigner;
use App\Entity\Yacht;
use App\Form\YachtType;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_USER")
 */
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

    #[Route('/new', name: 'yacht_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
        return $this->render('yacht/show.html.twig', [
            'yacht' => $yacht,
        ]);
    }

    #[Route('/{id}/edit', name: 'yacht_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Yacht $yacht): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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

    #[Route('/{id}', name: 'yacht_delete', methods: ['POST'])]
    public function delete(Request $request, Yacht $yacht): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $yacht->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($yacht);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('yacht_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete-image/{imageIndex}', name: 'yacht_delete_image', methods: ['GET'])]
    public function deleteImage(Yacht $yacht, int $imageIndex): Response
    {
        $this->assigner->unassign($yacht, $imageIndex);

        $this->entityManager->flush();

        return $this->redirectToRoute('yacht_edit', ['id' => $yacht->getId()], Response::HTTP_SEE_OTHER);
    }
}
