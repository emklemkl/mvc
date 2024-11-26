<?php

namespace App\Controller;

use App\Entity\Library;
use App\Service\LibraryService;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\LibraryType;
use App\Library\LibraryUtil;

class LibraryController extends AbstractController
{
    #[Route('/library/books', name: 'library')]
    public function showAllLibraryBooks(
        LibraryRepository $libRepository,
    ): Response {
        $library = new Library();
        $lib = $libRepository->findAll();

        $form = $this->createForm(LibraryType::class, $library, [
            'action' => $this->generateUrl('library_create_book'), // Set form action here
            'method' => 'POST',
        ])->add('add', SubmitType::class, ['label' => 'Add book']);

        return $this->render('library/index.html.twig', [
            'all_books' => $lib,
            "form" => $form->createView()
        ]);
    }

    #[Route('/library/book/create', name: 'library_create_book', methods: ["POST"])]
    public function createBook(
        LibraryService $libraryService,
        Request $request
    ): Response {

        $library = new Library();
        $form = $this->createForm(LibraryType::class, $library);
        $form->handleRequest($request);
        $isSuccess = $libraryService->persistBook($form, $library);
        if ($isSuccess) {
            return $this->redirectToRoute('library');
        }
        return new Response("No book was created");

        // }
        
    }

    #[Route('/library/book/view/{isbn}', name: 'library_view_book')]
    public function showLibraryBook(
        LibraryRepository $libRepository,
        string $isbn
    ): Response {
        $book = $libRepository->findByIsbnField($isbn);
        $library = new Library();
        $library->setTitle($book[0]->getTitle());
        $library->setIsbn($isbn);
        $library->setAuthor($book[0]->getAuthor());
        $library->setCover($book[0]->getCover());

        $formUpdate = $this->createForm(LibraryType::class, $library, [
            'action' => $this->generateUrl('library_update_book', ["id" => $book[0]->getId()]), // Set form action here
            'method' => 'POST',
        ])->add('add', SubmitType::class, ['label' => 'Update']);
        $formDelete = $this->createForm(LibraryType::class, $library, [
            'action' => $this->generateUrl('library_delete_book'), // Set form action here
            'method' => 'POST',
            'only_isbn' => true
        ]);
        return $this->render('library/library_view_book.twig', [
            'all_books' => $book,
            "formDelete" => $formDelete->createView(),
            "formUpdate" => $formUpdate->createView(),
        ]);
    }

    #[Route("/library/book/delete", name: "library_delete_book", methods: ["POST"])]  // SHOULD BE POST
    public function deleteLibraryBook(
        LibraryService $libraryService,
        Request $request,
    ): Response {
        $library = new Library();
        $form = $this->createForm(LibraryType::class, $library, [
        'only_isbn' => true
        ]);
        $form->handleRequest($request);
        $isSuccess = $libraryService->destroyBook($form, $library);
        if ($isSuccess) {
            return $this->redirectToRoute('library');
        }
        return new Response("No book was deleted");

    }

    #[Route("library/book/update/{id}", name: "library_update_book", methods: ["POST"])] // SHOULD BE POST WITH DETAILS IN BODY
    public function updateLibraryBook(
        Request $request,
        LibraryService $libraryService,
        int $id
    ): Response {

        $book = $libraryService->getRepoById($id);
        $form = $this->createForm(LibraryType::class, $book);
        $form->handleRequest($request);
        $isSuccess = $libraryService->modifyBook($form, $id);
        if ($isSuccess) {
            return $this->redirectToRoute("library_view_book", ["isbn" => $book->getIsbn()]);
        }
        return new Response("No book was deleted");
    }
}
