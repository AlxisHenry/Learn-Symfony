<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /*#[Route('/', name: 'homepage')]*/
    /**
     * @Route("/", name="homepage", methods={"GET","HEAD"})
     * @return Response
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $users = $entityManager->getRepository(Users::class)->findAll();

        return $this->render('home/home.html.twig', [
            'users' => $users
        ]);
    }
}
