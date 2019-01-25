<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\ActorRepository;
use App\Repository\CommentRepository;
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
        $user = $this->getUser();
        $movies = $movieRepository->findAll();
        $actors = $actorRepository->findAll();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
            'actors' => $actors,
            'user' => $user
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movie_show", methods="GET")
     */
    public function show(Movie $movie, CommentRepository $commentRepository): Response
    {
        $user = $this->getUser();
        $comments = $commentRepository->findByMovie($movie);
        $notes = $commentRepository->findByMovie(['id' => $movie->getId()]);
        $totalNote = 0;
        foreach($notes as $note) {
            $totalNote += $note->getNote();
        }
        $average = $totalNote/ count($notes);

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'user' => $user,
            'actors' => $movie->getActors(),
            'comments' => $comments,
            'average' => $average
        ]);
    }
}
