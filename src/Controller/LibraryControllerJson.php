<?php

namespace App\Controller;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LibraryControllerJson extends AbstractController
{
    #[Route('api/library/books', name: 'api_library')]
    public function showAllLibraryBooks(
        LibraryRepository $libRepository
    ): Response {
        $lib = $libRepository->findAll();
        return $this->json($lib);
    }

    #[Route('api/library/book/{isbn}', name: 'api_library_view_book')]
    public function showLibraryBook(
        LibraryRepository $libRepository,
        string $isbn
        ): Response {
        // $book = $libRepository->find($isbn);
        $book = $libRepository->findByIsbnField("$isbn");

        return $this->json($book);
    }
}
