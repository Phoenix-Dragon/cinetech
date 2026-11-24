<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MovieRepository;

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
        $movies = $movieRepository->findAllWithCategory();
        return $this->json($movies);
    }
}
