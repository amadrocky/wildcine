<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Comment;
use App\Entity\Movie;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("comment/movie/{id}", name="comment_movie", methods={"GET","POST"})
     */
    public function newMovieComment(Request $request, Movie $movie): Response
    {
        $user = $this->getUser();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setMovie($movie);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Comment added !');

            return $this->redirectToRoute('movie_show', array('id' => $movie->getId()));
        }

        return $this->render('comment/movie_comment.html.twig', [
            'comment' => $comment,
            'user' => $user,
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("comment/actor/{id}", name="comment_actor", methods={"GET","POST"})
     */
    public function newActorComment(Request $request, Actor $actor): Response
    {
        $user = $this->getUser();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setActor($actor);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Comment added !');

            return $this->redirectToRoute('actor_show', array('id' => $actor->getId()));
        }

        return $this->render('comment/actor_comment.html.twig', [
            'comment' => $comment,
            'user' => $user,
            'actor' => $actor,
            'form' => $form->createView(),
        ]);
    }
}
