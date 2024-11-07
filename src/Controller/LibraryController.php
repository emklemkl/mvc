<?php

namespace App\Controller;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LibraryController extends AbstractController
{
    #[Route('/library/books', name: 'library')]
    public function showAllLibraryBooks(
        LibraryRepository $libRepository
    ): Response {
        $task = new Library();
        $task->setAuthor('Write a blog post');
        $task->setCover("img/book_cover.webp");

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl("library_create_book"))
            ->setMethod('POST')
            ->add('title', TextType::class)
            ->add('isbn', TextType::class)
            ->add('author', TextType::class)
            ->add('cover', TextType::class, ["data" => "img/book_cover.webp"])
            ->add('add', SubmitType::class, ['label' => 'Add Book'])
            ->getForm();
        // $form = $this->createForm(LibraryType::class, $task);
        $lib = $libRepository->findAll();
        return $this->render('library/index.html.twig', [
            'all_books' => $lib, "form" => $form->createView() 
        ]);
    }

    #[Route('/library/book/create', name: 'library_create_book', methods: ["POST"])]
    public function createBook(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $randNumber = rand(1000000, 9999999);
        $entityManager = $doctrine->getManager();

        // Retrieve and handle the form
        $form = $this->createFormBuilder()
            ->add('title', TextType::class)
            ->add('isbn', TextType::class)
            ->add('author', TextType::class)
            ->add('cover', TextType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
        
        $data = $form->getData();
        $book = new Library();
        $book->setTitle($data["title"]);
        $book->setAuthor($data["author"]);
        $book->setIsbn(isset($data["isbn"]) ? strval($data["isbn"]) : strval($randNumber));
        $book->setCover(isset($data["cover"]) ? ($data["cover"]) : "./path/to/image.png");

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('library');
        }
    return new Response("No book was created");
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
