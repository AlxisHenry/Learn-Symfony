<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertiesController extends AbstractController
{
    /**
     * @Route("/properties/new", name="properties", methods={"GET","HEAD"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('properties/properties.html.twig');
    }

    /**
     * @Route("/properties/{id}/{action}", name="properties.action", methods={"GET","POST"})
     * @return Response
     */
    public function action(int $id, string $action, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(Users::class)->find($id);

        if ($action === 'delete') {
            // todo => Delete user from db and redirect him to submit page
            return $this->redirectToRoute('properties.submit');
        }

        return $this->render('properties/properties.html.twig', [
            'action' => $action,
            'id' => $id,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/properties/submit/{action}", name="properties.submit", methods={"GET","POST"})
     * @return Response
     * */
    public function submit(ManagerRegistry $doctrine, string $action) :Response {
        $entityManager = $doctrine->getManager();
        // todo => Show confirmation message
        // todo => Add user if [action === new]
        if(count($_POST) < 5) {
            return $this->redirectToRoute('homepage');
        }
        $new_user = [
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'email' => strtolower($_POST['username'].'@'.$_POST['suffix_mail']),
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'zip' => $_POST['zip'],
        ];
        if(!($entityManager->getRepository(Users::class)->findBy(['username' => $new_user['username']]))) {
            $user = new Users();
            $user->setUsername($new_user['username']);
            $user->setPassword($new_user['password']);
            $user->setEmail($new_user['email']);
            $user->setCity($new_user['city']);
            $user->setState($new_user['state']);
            $user->setZip($new_user['zip']);
            $entityManager->persist($user);
            $entityManager->flush();
        } else {
            $user = $entityManager->getRepository(Users::class)->find(4);
            $user->setUsername = "Alexis2";
            $entityManager->flush();
        }
        return $this->render('properties/properties.submit.html.twig', ['user' => $new_user]);
    }

}
