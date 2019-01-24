<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/box_office", name="box_office")
     */
    public function indexBoxOffice(MovieRepository $movieRepository)
    {
        $user = $this->getUser();
        $movies = $movieRepository->findByBoxOffice(true);

        return $this->render('news/indexBoxOffice.html.twig', [
            'movies' => $movies,
            'user' => $user
        ]);
    }


    /**
    * @Route("/news", name="news")
    */
    public function indexNews(MovieRepository $movieRepository)
    {
        $user = $this->getUser();
        $movies = $movieRepository->findByNovelty(true);

        return $this->render('news/indexNews.html.twig', [
            'movies' => $movies,
            'user' => $user
        ]);
    }
}
