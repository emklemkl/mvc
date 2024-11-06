<?php

namespace App\Controller;

use App\Entity\Ost;
use App\Repository\OstRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OstController extends AbstractController
{
    #[Route('/ost', name: 'app_ost')]
    public function index(): Response
    {
        return $this->render('ost/index.html.twig', [
            'controller_name' => 'OstController',
        ]);
    }

    #[Route('/ost/create', name: 'ost_create')]
    public function createOst(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $ost = new Ost();
        $ost->setName('Keyboard_num_' . rand(1, 9));
        $ost->setValue(rand(100, 999));

        // tell Doctrine you want to (eventually) save the ost
        // (no queries yet)
        $entityManager->persist($ost);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new ost with id ' . $ost->getId());
    }

    #[Route('/ost/show', name: 'ost_show_all')]
    public function showAllOst(
        OstRepository $ostRepository
    ): Response {
        $ost = $ostRepository
            ->findAll();

        return $this->json($ost);
    }

    #[Route('/ost/show/{id}', name: 'ost_by_id')]
    public function showOstById(
        OstRepository $ostRepository,
        int $id
    ): Response {
        $ost = $ostRepository
            ->find($id);

        return $this->json($ost);
    }

    #[Route('/ost/delete/{id}', name: 'ost_delete_by_id')]
    public function deleteOstById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $ost = $entityManager->getRepository(Ost::class)->find($id);

        if (!$ost) {
            throw $this->createNotFoundException(
                'No ost found for id ' . $id
            );
        }

        $entityManager->remove($ost);
        $entityManager->flush();

        return $this->redirectToRoute('ost_show_all');
    }

    #[Route('/ost/update/{id}/{value}', name: 'ost_update')]
    public function updateOst(
        ManagerRegistry $doctrine,
        int $id,
        int $value
    ): Response {
        $entityManager = $doctrine->getManager();
        $ost = $entityManager->getRepository(Ost::class)->find($id);

        if (!$ost) {
            throw $this->createNotFoundException(
                'No ost found for id ' . $id
            );
        }

        $ost->setValue($value);
        $entityManager->flush();

        return $this->redirectToRoute('ost_show_all');
    }

    #[Route('/ost/view', name: 'ost_view_all')]
    public function viewAllOst(
        OstRepository $ostRepository
    ): Response {
        $ost = $ostRepository->findAll();

        $data = [
            'ost' => $ost
        ];

        return $this->render('ost/view.html.twig', $data);
    }

    #[Route('/ost/view/{value}', name: 'ost_view_minimum_value')]
    public function viewOstWithMinimumValue(
        OstRepository $productRepository,
        int $value
    ): Response {
        $ost = $productRepository->findByMinimumValue($value);

        $data = [
            'ost' => $ost
        ];

        return $this->render('ost/view.html.twig', $data);
    }

    #[Route('/ost/show/min/{value}', name: 'ost_by_min_value')]
    public function showOstByMinimumValue(
        OstRepository $ostRepository,
        int $value
    ): Response {
        $ost = $ostRepository->findByMinimumValue2($value);

        return $this->json($ost);
    }
}
