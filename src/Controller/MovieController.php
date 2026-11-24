<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;

final class MovieController extends AbstractController
{
    #[Route('/movies', name: 'app_movie', methods: ['GET'])]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAllWithCategory();
        return $this->render('movie/index.html.twig', ['movies' => $movies]);
    }

    #[Route('/catalogue', name: 'app_movie_index', methods: ['GET'])]
    public function showCatalogue(Request $request): Response
    {
        $tag = $request->query->get('search', 'general');
        return $this->render('movie/index.html.twig', ['tag' => $tag]);
    }

    #[Route('/movie/{id}', name: 'app_movie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showMovieDetail(int $id): Response
    {
        return $this->render('movie/index.html.twig', ['tag' => $id]);
    }

    #[Route('/api/catalogue', name: 'api_movie_list', methods: ['GET'])]
    public function APICatalogueShow(MovieRepository $movieRepository): Response
    {
        return $this->json($movieRepository->findAllWithCategory());
    }

    #[Route('/catalogue/nouveau', name: 'app_movie_new', methods: ['GET', 'POST'])]
    public function AddNewMovie(Request $request, EntityManagerInterface $em): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($movie);
            $em->flush();

            $this->addFlash('success', 'Le produit a bien été créé.');
            return $this->redirectToRoute('app_movies', [], Response::HTTP_SEE_OTHER);
        }
        // Symfony 8 convertit $form en FormView et renvoie 422 automatiquement si invalide
        return $this->render('movie/new.html.twig', ['form' => $form]);
    }
}
