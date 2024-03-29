<?php

namespace App\Controller;

use App\Entity\Aircraft;
use App\Form\AircraftType;
use App\libs\VRSData;
use App\Repository\AircraftPositionRepository;
use App\Repository\AircraftRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/aircraft')]
class AircraftController extends AbstractController
{
    #[Route('/', name: 'app_aircraft_index', methods: ['GET'])]
    public function index(AircraftRepository $aircraftRepository, Request $request): Response
    {
        $queryBuilder = $aircraftRepository->createQueryBuilder('a');
        $query = $request->get('q');
        if ($query) {
            $queryBuilder
                ->andWhere('a.registration LIKE :query')
                ->orWhere('a.icao LIKE :query')
                ->setParameter('query', '%' . strtoupper($query) . '%');
        }
        $adapter = new QueryAdapter($queryBuilder);
        $pagerFanta = Pagerfanta::createForCurrentPageWithMaxPerPage($adapter, $request->get('page', 1), 20);

        return $this->render('aircraft/index.html.twig', [
            'aircrafts' => $pagerFanta,
            'query' => $query,
        ]);
    }

    #[Route('/{icao}', name: 'app_aircraft_show', methods: ['GET'])]
    public function show(Aircraft $aircraft, AircraftRepository $aircraftRepository, AircraftPositionRepository $aircraftPositionRepository): Response
    {
        if ($aircraft->updatePhotoFromPlaneSpotters()) {
            $aircraftRepository->save($aircraft, true);
        }
        $lastAircraftPosition = $aircraftPositionRepository->getLastPosition($aircraft->getIcao());
        $isLiveTracking = $lastAircraftPosition && $lastAircraftPosition->getPositionAt() > new \DateTimeImmutable('-5 minutes');
        //seconds since last seen
        $secondsSinceLastSeen = $lastAircraftPosition ? time() - $lastAircraftPosition->getPositionAt()->getTimestamp() : 0;
        $lastSeenString = $secondsSinceLastSeen <= 90 ? "$secondsSinceLastSeen seconds ago" : ($secondsSinceLastSeen / 60) . ' minutes ago';
        return $this->render('aircraft/show.html.twig', [
            'aircraft' => $aircraft,
            'lastAircraftPosition' => $lastAircraftPosition,
            'isLiveTracking' => $isLiveTracking,
            'lastSeen' => $lastSeenString,
        ]);
    }

    #[Route('/{icao}/edit', name: 'app_aircraft_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
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

    #[Route('/{icao}', name: 'app_aircraft_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Aircraft $aircraft, AircraftRepository $aircraftRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $aircraft->getId(), $request->request->get('_token'))) {
            $aircraftRepository->remove($aircraft, true);
        }

        return $this->redirectToRoute('app_aircraft_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{icao}/data-update', name: 'app_aircraft_update_details', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function dataUpdate(Request $request, Aircraft $aircraft, AircraftRepository $aircraftRepository): Response
    {
        $vrsData = new VRSData();
        $data = $vrsData->getAircraftData([$aircraft->getIcao()]);
        $vrsDataResult = VRSData::findAircraft($data, $aircraft->getIcao());
        if (!empty($vrsDataResult)) {
            $aircraft->updateFromVRSData($vrsDataResult);
            $aircraftRepository->save($aircraft, true);
            $this->addFlash('success', 'Aircraft data updated');
        } else {
            $this->addFlash('warning', 'Aircraft data not found');
        }
        return $this->redirectToRoute('app_aircraft_show', ['icao' => $aircraft->getIcao()], Response::HTTP_SEE_OTHER);
    }
}
