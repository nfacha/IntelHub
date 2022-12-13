<?php

namespace App\Controller;

use App\Entity\Aircraft;
use App\Form\AircraftType;
use App\Repository\AircraftRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/aircraft')]
class AircraftController extends AbstractController
{
    #[Route('/', name: 'app_aircraft_index', methods: ['GET'])]
    public function index(AircraftRepository $aircraftRepository): Response
    {
        $queryBuilder = $aircraftRepository->createQueryBuilder('a');
        $adapter = new QueryAdapter($queryBuilder);
        $pagerFanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, 1, 20);

        return $this->render('aircraft/index.html.twig', [
            'aircraft' => $pagerFanta,
        ]);
    }

    #[Route('/new', name: 'app_aircraft_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AircraftRepository $aircraftRepository): Response
    {
        $aircraft = new Aircraft();
        $form = $this->createForm(AircraftType::class, $aircraft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aircraftRepository->save($aircraft, true);

            return $this->redirectToRoute('app_aircraft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aircraft/new.html.twig', [
            'aircraft' => $aircraft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aircraft_show', methods: ['GET'])]
    public function show(Aircraft $aircraft): Response
    {
        return $this->render('aircraft/show.html.twig', [
            'aircraft' => $aircraft,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_aircraft_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aircraft $aircraft, AircraftRepository $aircraftRepository): Response
    {
        $form = $this->createForm(AircraftType::class, $aircraft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aircraftRepository->save($aircraft, true);

            return $this->redirectToRoute('app_aircraft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('aircraft/edit.html.twig', [
            'aircraft' => $aircraft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aircraft_delete', methods: ['POST'])]
    public function delete(Request $request, Aircraft $aircraft, AircraftRepository $aircraftRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $aircraft->getId(), $request->request->get('_token'))) {
            $aircraftRepository->remove($aircraft, true);
        }

        return $this->redirectToRoute('app_aircraft_index', [], Response::HTTP_SEE_OTHER);
    }
}
