<?php

namespace App\Controller;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    #[Route('/library/books', name: 'library')]
    public function showAllLibraryBooks(
        LibraryRepository $libRepository
    ): Response {
        $lib = $libRepository->findAll();
        return $this->render('library/index.html.twig', [
            'all_books' => $lib,
        ]);
    }

    #[Route('/library/book/create', name: 'library_create_book')]
    public function createBook(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Library();
        $book->setTitle("A fancy book");
        $book->setAuthor("Some Writer");
        $book->setIsbn("0123456781");
        $book->setCover("./path/to/image.png");


        // tell Doctrine you want to (eventually) save the book
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new book with id ' . $book->getId());
    }

    #[Route('/library/book/view/{isbn}', name: 'library_view_book')]
    public function showLibraryBook(
        LibraryRepository $libRepository,
        string $isbn
        ): Response {
        $book = $libRepository->findByIsbnField($isbn);

        return $this->json($book);
    }

    #[Route("/library/book/delete/{id}", name: "library_delete", methods: ["POST"])]  // SHOULD BE POST
    public function deleteLibraryBook(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Library::class)->find($id);
        if (!$book) {
            throw $this->createNotFoundException(
                "No book found on this id". $id
            );
        }
        $entityManager->remove($book);
        $entityManager->flush();
        return $this->redirectToRoute('library');
    }

    #[Route("library/book/update/{id}", name: "library_update", methods: ["POST"])] // SHOULD BE POST WITH DETAILS IN BODY
    public function updateLibraryBook(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Library::class)->find($id);
        if (!$book) {
            throw $this->createNotFoundException(
                "No book found on this id" . $id
            );
        }
        $book->setTitle("New title");
        $entityManager->flush();
        return $this->redirectToRoute("library_view_book", ["id"=> $id]);
    }
}
