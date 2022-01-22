<?php

namespace App\Controller;

use App\Entity\Yacht;
use App\Form\YachtType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints\Uuid;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 *
 * @IsGranted("ROLE_USER")
 */
#[Route('/yacht')]
class YachtController extends AbstractController
{

    #[Route('/', name: 'yacht_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $yachts = $entityManager
            ->getRepository(Yacht::class)
            ->findAll();

        return $this->render('yacht/index.html.twig', [
            'yachts' => $yachts,
        ]);
    }

    #[Route('/new', name: 'yacht_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $yacht = new Yacht();
        $form = $this->createForm(YachtType::class, $yacht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$yacht -> setId(Uuid::v4()); TODO Generate random UUID so the user does not have to write it manually (should not be visible at all)
            $entityManager->persist($yacht);
            $entityManager->flush();

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
    public function edit(Request $request, Yacht $yacht, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(YachtType::class, $yacht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('yacht_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('yacht/edit.html.twig', [
            'yacht' => $yacht,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'yacht_delete', methods: ['POST'])]
    public function delete(Request $request, Yacht $yacht, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$yacht->getId(), $request->request->get('_token'))) {
            $entityManager->remove($yacht);
            $entityManager->flush();
        }

        return $this->redirectToRoute('yacht_index', [], Response::HTTP_SEE_OTHER);
    }
}
