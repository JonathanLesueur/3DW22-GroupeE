<?php

namespace App\Controller;

use App\Entity\BookCategory;
use App\Form\BookCategoryType;
use App\Repository\BookCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book/category")
 */
class BookCategoryController extends AbstractController
{
    /**
     * @Route("/", name="book_category_index", methods={"GET"})
     */
    public function index(BookCategoryRepository $bookCategoryRepository): Response
    {
        return $this->render('book_category/index.html.twig', [
            'book_categories' => $bookCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="book_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bookCategory = new BookCategory();
        $form = $this->createForm(BookCategoryType::class, $bookCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookCategory);
            $entityManager->flush();

            return $this->redirectToRoute('book_category_index');
        }

        return $this->render('book_category/new.html.twig', [
            'book_category' => $bookCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_category_show", methods={"GET"})
     */
    public function show(BookCategory $bookCategory): Response
    {
        return $this->render('book_category/show.html.twig', [
            'book_category' => $bookCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BookCategory $bookCategory): Response
    {
        $form = $this->createForm(BookCategoryType::class, $bookCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_category_index');
        }

        return $this->render('book_category/edit.html.twig', [
            'book_category' => $bookCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BookCategory $bookCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bookCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_category_index');
    }
}
