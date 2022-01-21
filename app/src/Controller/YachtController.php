<?php

namespace App\Controller;

use App\Entity\Yacht;
use App\Form\YachtType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $yacht = new Yacht();
        $form = $this->createForm(YachtType::class, $yacht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        if ($this->isCsrfTokenValid('delete'.$yacht->getId(), $request->request->get('_token'))) {
            $entityManager->remove($yacht);
            $entityManager->flush();
        }

        return $this->redirectToRoute('yacht_index', [], Response::HTTP_SEE_OTHER);
    }
}
