<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Message send !');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'contact' => $contact,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
