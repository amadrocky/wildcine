<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\ActorRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     */
    public function index(MovieRepository $movieRepository, ActorRepository $actorRepository)
    {
        $movies = $movieRepository->findAll();
        $actors = $actorRepository->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
            'actors' => $actors
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movie_show", methods="GET")
     */
    public function show(Movie $movie): Response
    {

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'actors' => $movie->getActors()
        ]);
    }
}
