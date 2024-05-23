<?php

namespace App\Controller;

use App\Entity\SecurityIncident;
use App\Form\SecurityIncidentType;
use App\Repository\SecurityIncidentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/security/incident')]
class SecurityIncidentController extends AbstractController
{
    #[Route('/', name: 'app_security_incident_index', methods: ['GET'])]
    public function index(SecurityIncidentRepository $securityIncidentRepository): Response
    {
        return $this->render('security_incident/index.html.twig', [
            'security_incidents' => $securityIncidentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_security_incident_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $securityIncident = new SecurityIncident();
        $form = $this->createForm(SecurityIncidentType::class, $securityIncident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($securityIncident);
            $entityManager->flush();

            return $this->redirectToRoute('app_security_incident_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security_incident/new.html.twig', [
            'security_incident' => $securityIncident,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_security_incident_show', methods: ['GET'])]
    public function show(SecurityIncident $securityIncident): Response
    {
        return $this->render('security_incident/show.html.twig', [
            'security_incident' => $securityIncident,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_security_incident_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SecurityIncident $securityIncident, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SecurityIncidentType::class, $securityIncident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_security_incident_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security_incident/edit.html.twig', [
            'security_incident' => $securityIncident,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_security_incident_delete', methods: ['POST'])]
    public function delete(Request $request, SecurityIncident $securityIncident, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$securityIncident->getId(), $request->request->get('_token'))) {
            $entityManager->remove($securityIncident);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_security_incident_index', [], Response::HTTP_SEE_OTHER);
    }
}
