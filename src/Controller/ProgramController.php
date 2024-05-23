<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProgramRepository;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/{id}',name: 'show', methods: ['GET'], requirements: ['id'=>'\d+'])]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        //var_dump($program);
        //die();
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/{programId}/season/{seasonId}',name: 'season_show', methods: ['GET'], requirements: ['programId'=>'\d+'])]
    public function showSeason(int $programId, int $seasonId, programRepository $programRepository, seasonRepository $seasonRepository): Response
    {
        //$programs = $seasonRepository->findOneBy(['program_id' => $programId]);
        $seasons = $seasonRepository->findOneBy(['id' => $seasonId]);

        return $this->render('program/season_show.html.twig', ['seasons' => $seasons]);
    }
}