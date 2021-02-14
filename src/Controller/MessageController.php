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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/subjects")
 * @IsGranted("ROLE_USER")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(MessageRepository $messageRepository): Response
    {
        $_subjectsList = $messageRepository->findBy(array('type' => 'subject', 'visible' => 1));

        return $this->render('message/index.html.twig', [
            'messages' => $_subjectsList,
        ]);
    }

    /**
     * @Route("/new", name="message_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
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
     * @IsGranted("ROLE_USER")
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
            
            $newMessage->setType('response');

            $response = new MessageResponse();
            $response->setMessageBaseId($message);
            $response->setMessageRepId($newMessage);

            $entityManager = $this->getDoctrine()->getManager();
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
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Message $message): Response
    {
        $isUser = $this->isGranted('ROLE_USER');
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        if($isAdmin) {

        } else if($isUser) {

        } else {
            return $this->redirectToRoute('message_index');
        }



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
     * @Route("/subject-{id}/delete", name="message_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
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
     * @Route("/subject-{id}/like", name="message_like", methods={"POST"})
     * @IsGranted("ROLE_USER")
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
     * @Route("/subject-{id}/dislike", name="message_dislike", methods={"POST"})
     * @IsGranted("ROLE_USER")
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
    /**
     * @Route("/subject-{id}/report", name="message_report", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function report(Request $request, Message $message): Response{
            $user = $this->getUser();

            return $this->redirectToRoute('message_show', ['id' => $message->getId()]);
    }
}
