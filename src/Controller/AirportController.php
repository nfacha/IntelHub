<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Form\AirportType;
use App\Repository\AirportRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/airport')]
class AirportController extends AbstractController
{
    #[Route('/', name: 'app_airport_index', methods: ['GET'])]
    public function index(AirportRepository $airportRepository, Request $request): Response
    {
        $queryBuilder = $airportRepository->createQueryBuilder('a');
        $query = $request->get('q');
        if ($query) {
            $queryBuilder
                ->andWhere('a.icao LIKE :query')
                ->orWhere('a.iata LIKE :query')
                ->orWhere('UPPER(a.name) LIKE :query')
                ->setParameter('query', '%' . strtoupper($query) . '%');
        }
        $adapter = new QueryAdapter($queryBuilder);
        $pagerFanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $request->get('page', 1), 20);

        return $this->render('airport/index.html.twig', [
            'airports' => $pagerFanta,
            'query' => $query,
        ]);
    }

    #[Route('/new', name: 'app_airport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AirportRepository $airportRepository): Response
    {
        $airport = new Airport();
        $form = $this->createForm(AirportType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $airportRepository->save($airport, true);

            return $this->redirectToRoute('app_airport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('airport/new.html.twig', [
            'airport' => $airport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airport_show', methods: ['GET'])]
    public function show(Airport $airport): Response
    {
        return $this->render('airport/show.html.twig', [
            'airport' => $airport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_airport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Airport $airport, AirportRepository $airportRepository): Response
    {
        $form = $this->createForm(AirportType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $airportRepository->save($airport, true);

            return $this->redirectToRoute('app_airport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('airport/edit.html.twig', [
            'airport' => $airport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airport_delete', methods: ['POST'])]
    public function delete(Request $request, Airport $airport, AirportRepository $airportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $airport->getId(), $request->request->get('_token'))) {
            $airportRepository->remove($airport, true);
        }

        return $this->redirectToRoute('app_airport_index', [], Response::HTTP_SEE_OTHER);
    }
}
