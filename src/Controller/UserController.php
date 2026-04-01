<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

final class UserController extends AbstractController
{
    #[Route('/mod-liste-users', name: 'liste-users')]
    public function listeUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/liste-users.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/mod-profil-users', name: 'profil-user')]
    public function listeProfil(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/profil-user.html.twig', [
            'users' => $users
        ]);
    }
}
