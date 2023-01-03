<?php

namespace App\Controller;

use App\Repository\AircraftPositionRepository;
use App\Repository\AircraftRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AircraftRepository $aircraftRepository, AircraftPositionRepository $aircraftPositionRepository): Response
    {
        $totalAircraft = $aircraftRepository->count([]);
        $totalAircraftToday = $aircraftRepository->count(['created_at' => new \DateTimeImmutable('today')]);
        $totalAircraftYesterday = $aircraftRepository->count(['created_at' => new \DateTimeImmutable('yesterday')]);
        $totalAircraftGrowthPercentage = $totalAircraftYesterday ? round(($totalAircraftToday - $totalAircraftYesterday) / $totalAircraftYesterday * 100, 2) : 0;

        $totalPositions = $aircraftPositionRepository->count([]);
        $totalPositionsToday = $aircraftPositionRepository->count(['position_at' => new \DateTimeImmutable('today')]);
        $totalPositionsYesterday = $aircraftPositionRepository->count(['position_at' => new \DateTimeImmutable('yesterday')]);
        $totalPositionsGrowthPercentage = $totalPositionsYesterday ? round(($totalPositionsToday - $totalPositionsYesterday) / $totalPositionsYesterday * 100, 2) : 0;

        $lastAircraftPositions = array_map(function ($aircraftPosition) use ($aircraftRepository) {
            return [
                'position_at' => $aircraftPosition->getPositionAt(),
                'aircraft' => $aircraftRepository->findOneBy(['icao' => $aircraftPosition->getIcao()]),
            ];
        }, $aircraftPositionRepository->findBy([], ['position_at' => 'DESC'], 10));
        return $this->render('site/index.html.twig', [
            'totalAircraft' => $totalAircraft,
            'totalPositions' => $totalPositions,
//            'totalPositionsToday' => $totalPositionsToday,
//            'totalPositionsYesterday' => $totalPositionsYesterday,
            'totalPositionsGrowthPercentage' => $totalPositionsGrowthPercentage,
//            'totalAircraftToday' => $totalAircraftToday,
//            'totalAircraftYesterday' => $totalAircraftYesterday,
            'totalAircraftGrowthPercentage' => $totalAircraftGrowthPercentage,
            'lastAircraftPositions' => $lastAircraftPositions,
        ]);
    }
}
