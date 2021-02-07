<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Like;
use App\Entity\Dislike;
use App\Entity\MessageResponse;
use App\Form\MessageType;
use App\Form\MessageResponseType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subjects")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/list", name="message_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            if($user) {
                $message->setUser($user);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/subject-{id}", name="message_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Message $message): Response
    {

        $newMessage = new Message();
        $form = $this->createForm(MessageResponseType::class, $newMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if($user) {
                $newMessage->setUser($user);
            }
            
            $entityManager = $this->getDoctrine()->getManager();

            $response = new MessageResponse();
            $response->setMessageBaseId($message);
            $response->setMessageRepId($newMessage);

            $entityManager->persist($newMessage);
            $entityManager->persist($response);
            $entityManager->flush();
        }


        return $this->render('message/show.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/subject-{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete-{id}", name="message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_index');
    }
    /**
     * @Route("/like-{id}", name="message_like", methods={"POST"})
     */
    public function like(Request $request, Message $message): Response
    {
        $user = $this->getUser();

        $like = new Like();
        $like->setUserId($user);
        $like->setMessageId($message);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($like);
        $entityManager->flush();

        return $this->redirectToRoute('message_index');


    }
    /**
     * @Route("/dislike-{id}", name="message_dislike", methods={"POST"})
     */
    public function dislike(Request $request, Message $message): Response
    {
        $user = $this->getUser();

        $dislike = new Dislike();
        $dislike->setUserId($user);
        $dislike->setMessageId($message);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($dislike);
        $entityManager->flush();

        return $this->redirectToRoute('message_index');


    }
}
