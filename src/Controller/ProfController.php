<?php

namespace App\Controller;

use App\Entity\Prof;
use App\Form\ProfType;
use App\Repository\ProfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/prof')]
final class ProfController extends AbstractController
{
    #[Route(name: 'app_prof_index', methods: ['GET'])]
    public function index(ProfRepository $profRepository): Response
    {
        return $this->render('prof/index.html.twig', [
            'profs' => $profRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prof_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prof = new Prof();
        $form = $this->createForm(ProfType::class, $prof);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($prof);
            $entityManager->flush();

            return $this->redirectToRoute('app_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prof/new.html.twig', [
            'prof' => $prof,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prof_show', methods: ['GET'])]
    public function show(Prof $prof): Response
    {
        return $this->render('prof/show.html.twig', [
            'prof' => $prof,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prof_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prof $prof, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfType::class, $prof);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_prof_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prof/edit.html.twig', [
            'prof' => $prof,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prof_delete', methods: ['POST'])]
    public function delete(Request $request, Prof $prof, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prof->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($prof);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prof_index', [], Response::HTTP_SEE_OTHER);
    }
}
