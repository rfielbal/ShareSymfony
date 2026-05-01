<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Form\FichierUserType;
use App\Repository\ScategorieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class UserController extends AbstractController
{
    #[Route('/private-liste-users', name: 'liste-users')]
    public function listeUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/liste-users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/private-profil-users', name: 'profil-user')]
    public function profilUser(Request $request, ScategorieRepository $scategorieRepository, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $fichier = new Fichier();

        $scategories = $scategorieRepository->findBy([], [
            'categorie' => 'asc',
            'numero' => 'asc',
        ]);

        $form = $this->createForm(FichierUserType::class, $fichier, [
            'scategories' => $scategories,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedScategories = $form->get('scategories')->getData();

            foreach ($selectedScategories as $scategorie) {
                $fichier->addScategory($scategorie);
            }

            $file = $form->get('fichier')->getData();

            if ($file) {
                $nomFichierServeur = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $nomFichierServeur = $slugger->slug($nomFichierServeur);
                $nomFichierServeur = $nomFichierServeur . '-' . uniqid() . '.' . $file->guessExtension();

                $fichier->setUser($this->getUser());
                $fichier->setNomServeur($nomFichierServeur);
                $fichier->setNomOriginal($file->getClientOriginalName());
                $fichier->setDateEnvoie(new \Datetime());
                $fichier->setExtension($file->guessExtension());
                $fichier->setTaille($file->getSize());

                $em->persist($fichier);
                $em->flush();

                $file->move($this->getParameter('file_directory'), $nomFichierServeur);

                $this->addFlash('notice', 'Fichier envoyé');
                return $this->redirectToRoute('profil-user');
            }
        }

        return $this->render('user/profil-user.html.twig', [
            'form' => $form->createView(),
            'scategories' => $scategories,
        ]);
    }

    #[Route('/private-telechargement-fichier-user/{id}', name: 'app_telechargement_fichier_user', requirements: ["id" => "\d+"])]
    public function telechargementFichierUser(Fichier $fichier)
    {
        if ($fichier->getUser() !== $this->getUser()) {
            $this->addFlash('notice', 'Vous n\'êtes pas le propriétaire de ce fichier');
            return $this->redirectToRoute('profil-user');
        }

        return $this->file(
            $this->getParameter('file_directory') . '/' . $fichier->getNomServeur(),
            $fichier->getNomOriginal()
        );
    }

}
