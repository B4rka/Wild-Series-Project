<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La nouvelle catégorie a bien été ajoutée');

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', ['form' => $form,]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : '.$categoryName.' found in category\'s table.'
            );
        }

        $programs = $programRepository->findBy(['category' => $category], ['id' => 'ASC'], 3);
        if (!$programs) {
            throw $this->createNotFoundException(
                'No program in category : '.$categoryName.' found in program\'s table.'
            );
        }

        return $this->render('category/show.html.twig', ['programs' => $programs,
            'category' => $category,]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('danger', 'La catégorie a bien été supprimée');

        return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
    }
}