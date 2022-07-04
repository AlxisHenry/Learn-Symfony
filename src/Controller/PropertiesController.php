<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/properties/submit/{action}", name="properties.submit", methods={"GET","POST"})
     * @return Response
     * */
    public function submit(ManagerRegistry $doctrine, string $action) :Response {

        $entityManager = $doctrine->getManager();

        $post_user = [];
        $return_values = [
            'action' => $action
        ];

        if($action === 'new' || $action === 'edit') {
            $post_user = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'email' => strtolower($_POST['username'].'@'.$_POST['suffix_mail']),
                'city' => $_POST['city'],
                'state' => $_POST['state'],
                'zip' => $_POST['zip'],
                'id' => $_POST['id'] ?? '',
                'token' => $_POST['token']
            ];
        }

        if(!$this->isCsrfTokenValid('action', $post_user['token'])) {
            return $this->redirectToRoute('homepage');
        }

        switch ($action) {
            case 'new':
                if (count($_POST) > 5) {
                    if(!($entityManager->getRepository(Users::class)->findBy(['username' => $post_user['username']]))) {
                        $user = new Users();
                        $user->setUsername($post_user['username']);
                        $user->setPassword($post_user['password']);
                        $user->setEmail($post_user['email']);
                        $user->setCity($post_user['city']);
                        $user->setState($post_user['state']);
                        $user->setZip($post_user['zip']);
                        $entityManager->persist($user);
                        $entityManager->flush();
                    }
                } else {
                    $this->redirectToRoute('homepage');
                }
                break;
            case 'edit':
                $user = $entityManager->getRepository(Users::class)->find($post_user['id']);
                $user->setUsername($post_user['username']);
                $user->setPassword($post_user['password']);
                $user->setEmail($post_user['email']);
                $user->setCity($post_user['city']);
                $user->setState($post_user['state']);
                $user->setZip($post_user['zip']);
                $entityManager->flush();
                break;
            default:
                $this->redirectToRoute('homepage');
        }


        return $this->render('properties/properties.submit.html.twig', ['user' => $post_user, 'action' => $action]);
    }

    /**
     * @Route("/property/w/{id}/{action}", name="properties.action", methods={"GET","POST"})
     * @return Response
     */
    public function action(int $id, string $action, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(Users::class)->find($id);

        if(!$user) {
            return $this->redirectToRoute('homepage');
        } else if ($action === 'delete') {
            $entityManager->remove($user);
            $entityManager->flush();
            return $this->redirectToRoute('properties.submit', ['action' => $action]);
        }

        return $this->render('properties/properties.html.twig', [
            'action' => $action,
            'id' => $id,
            'user' => $user,
        ]);
    }

}
