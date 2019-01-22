<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Repository\ActorRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @Route("/actors", name="actors")
     */
    public function index(MovieRepository $movieRepository, ActorRepository $actorRepository)
    {
        $movies = $movieRepository->findAll();
        $actors = $actorRepository->findAll();

        return $this->render('actor/index.html.twig', [
            'movies' => $movies,
            'actors' => $actors
        ]);
    }

    /**
     * @Route("/actor/{id}", name="actor_show", methods="GET")
     */
    public function show(Actor $actor): Response
    {

        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
            'movies' => $actor->getmovies()
        ]);
    }
}
