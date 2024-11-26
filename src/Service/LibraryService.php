<?php
namespace App\Service;
use App\Entity\Library;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibraryRepository;
use App\Library\LibraryUtil;

class LibraryService {
    private ManagerRegistry $doctrine;
    private LibraryRepository $libRepository;

    public function __construct(ManagerRegistry $doctrine, LibraryRepository $libRepository,) {
        $this->doctrine = $doctrine; 
        $this->libRepository = $libRepository; 
    }

    public function persistBook($form, $library): bool {
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($library);
            $entityManager->flush();
            return true; # Success
            }
        return false; # Fail
        }

    public function destroyBook($form, $library): bool {
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $isbn = $library->getIsbn();
            $book = $this->libRepository->findByIsbnField($isbn);
            LibraryUtil::bookExists($book);
            $entityManager->remove($book[0]);
            $entityManager->flush();
            return true; # Success
        }
        return false; # Fail
        }

    public function modifyBook($form): bool {
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->flush();
            return true; # Success
        }
        return false; # Fail
        }

    public function getRepoById($id) {
        $entityManager = $this->doctrine->getManager();
        $book = $entityManager->getRepository(Library::class)->find($id);
        LibraryUtil::bookExists($book);
        return $book;
    } 
    }
