<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($program);
            $entityManager->flush();

            $this->addFlash('success', 'Le nouveau programme a bien été ajouté');
            //$this->addFlash('danger', 'Le programme a bien été supprimé');

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', ['form' => $form,]);
    }

    #[Route('/{id}',name: 'show', methods: ['GET'], requirements: ['id'=>'\d+'])]
    public function show(Program $program): Response
    {
        //var_dump($program);
        //die();
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$program['id'].' found in program\'s table.'
            );
        }


        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/{program}/season/{season}',name: 'season_show', methods: ['GET'], requirements: ['programId'=>'\d+'])]
    public function showSeason(Program $program, Season $season): Response
    {
        //$programs = $seasonRepository->findOneBy(['program_id' => $programId]);
        //$seasons = $seasonRepository->findOneBy(['id' => $seasonId]);

        return $this->render('program/season_show.html.twig', ['seasons' => $season,
            'program' => $program]);
    }

    #[Route('/{program}/season/{season}/episode/{episode}',name: 'season_episode_show_', methods: ['GET'], requirements: ['programId'=>'\d+'])]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', ['episode' => $episode,
            'program' => $program,
            'season' => $season]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($program);
        $entityManager->flush();
        $this->addFlash('danger', 'Le programme a bien été supprimé');


        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }
}