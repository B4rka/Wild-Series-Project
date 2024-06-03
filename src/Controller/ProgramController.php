<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\EpisodeType;
use App\Form\ProgramType;
use App\Form\CommentsType;
use App\Repository\SeasonRepository;
use App\Service\ProgramDuration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProgramRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

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
    public function new(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);
            $entityManager->persist($program);
            $entityManager->flush();

            $this->addFlash('success', 'Le nouveau programme a bien été ajouté');

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('p.e.dejonghe@gmail.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('Program/newProgramEmail.html.twig', ['program' => $program]));

            $mailer->send($email);

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', ['form' => $form,]);
    }

    #[Route('/{slug}',name: 'show', methods: ['GET'], requirements: ['id'=>'\d+'])]
    public function show(Program $program, ProgramDuration $programDuration): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program : '.$program['slug'].' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program,
            'programDuration' => $programDuration->calculate($program)
        ]);
    }

    #[Route('/{program_slug}/season/{season}',name: 'season_show', methods: ['GET'])]
    public function showSeason(
        #[MapEntity(mapping: ['program_slug' => 'slug'])] Program $program,
        Season $season): Response
    {

        return $this->render('program/season_show.html.twig', ['seasons' => $season,
            'program' => $program]);
    }

    #[Route('/{program_slug}/season/{season}/episode/{episode_slug}',name: 'season_episode_show_', requirements: ['programId'=>'\d+'])]
    public function showEpisode(#[MapEntity(mapping: ['program_slug' => 'slug'])] Program $program,
                                Season $season,
                                #[MapEntity(mapping: ['episode_slug' => 'slug'])] Episode $episode,
                                EntityManagerInterface $entityManager,
                                Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setEpisode($episode);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('program_season_episode_show_',
                ['program_slug' => 'slug', 'season' => 'id', 'episode_slug' => 'slug']);
        }

        return $this->render('program/episode_show.html.twig', ['episode' => $episode,
            'program' => $program,
            'season' => $season,
            'form' => $form]);
    }
    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/delete', name: 'delete')]
    public function delete(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($program);
        $entityManager->flush();
        $this->addFlash('danger', 'Le programme a bien été supprimé');


        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }
}