<?php

namespace App\Controller;

use App\Entity\Risk;
use App\Form\RiskType;
use App\Repository\RiskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/risk')]
class RiskController extends AbstractController
{
    #[Route('/', name: 'app_risk_index', methods: ['GET'])]
    public function index(RiskRepository $riskRepository): Response
    {
        return $this->render('risk/index.html.twig', [
            'risks' => $riskRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_risk_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $risk = new Risk();
        $form = $this->createForm(RiskType::class, $risk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($risk);
            $entityManager->flush();

            return $this->redirectToRoute('app_risk_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('risk/new.html.twig', [
            'risk' => $risk,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_risk_show', methods: ['GET'])]
    public function show(Risk $risk): Response
    {
        return $this->render('risk/show.html.twig', [
            'risk' => $risk,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_risk_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Risk $risk, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RiskType::class, $risk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_risk_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('risk/edit.html.twig', [
            'risk' => $risk,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_risk_delete', methods: ['POST'])]
    public function delete(Request $request, Risk $risk, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$risk->getId(), $request->request->get('_token'))) {
            $entityManager->remove($risk);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_risk_index', [], Response::HTTP_SEE_OTHER);
    }
}
