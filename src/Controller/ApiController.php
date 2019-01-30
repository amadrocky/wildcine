<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(Request $request, SessionInterface $session): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $searchResult = str_replace(' ', '+', $data['movie_search']);

            $client = new \GuzzleHttp\Client([
                    'base_uri' => 'http://www.omdbapi.com/',
                ]
            );

            $response = $client->request('GET', '?t='.$searchResult.'&apikey=8548d355');

            $body = $response->getBody();
            $body->getContents();

            $json=json_decode($body,true);

            return $this->render('api/index.html.twig',[
                'jsonResult' => $session->set('jsonResult', $json),
                'json' => $json,
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('api/index.html.twig',[
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @param SessionInterface $session
     * @return Response
     * @Route("/addMovie", name="addMovie")
     */
    public function addMovie(SessionInterface $session): Response
    {
        $movie = new Movie();

        $json = $session->get('jsonResult');

        $em = $this->getDoctrine()->getManager();
        $movie->setTitle($json['Title']);
        $movie->setKind($json['Genre']);
        $movie->setYear($json['Year']);
        $movie->setDirector($json['Director']);
        $movie->setSynopsis($json['Plot']);
        $movie->setCountry($json['Country']);
        $movie->setImage($json['Poster']);
        $movie->setBoxOffice(false);
        $movie->setNovelty(true);
        $em->persist($movie);
        $em->flush();

        $this->addFlash('success', 'Movie added');

        return $this->redirectToRoute('api');
    }
}
