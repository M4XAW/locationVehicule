<?php

namespace App\Controller;

use App\Entity\Vehicules;
use App\Form\VehiculesType;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class VehiculesController extends AbstractController
{
    #[Route(name: 'app_vehicules_index', methods: ['GET'])]
    public function index(VehiculesRepository $vehiculesRepository): Response
    {
        return $this->render('vehicules/index.html.twig', [
            'vehicules' => $vehiculesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vehicules_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicule = new Vehicules();
        $form = $this->createForm(VehiculesType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicules_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehicules/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicules_show', methods: ['GET'])]
    public function show(Vehicules $vehicule): Response
    {
        return $this->render('vehicules/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vehicules_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicules $vehicule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehiculesType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vehicules_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehicules/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicules_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicules $vehicule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($vehicule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vehicules_index', [], Response::HTTP_SEE_OTHER);
    }
}
