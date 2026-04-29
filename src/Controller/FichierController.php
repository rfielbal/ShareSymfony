<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Form\FichierType;
use App\Repository\FichierRepository;
use App\Repository\UserRepository;
use App\Repository\ScategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FichierController extends AbstractController
{
    #[Route('/private-fichier', name: 'app_ajout_fichier')]
    public function ajoutFichier(Request $request, ScategorieRepository $scategorieRepository, EntityManagerInterface $em): Response
    {
        $fichier = new Fichier();
        $scategories = $scategorieRepository->findBy([], ['categorie' => 'asc', 'numero' => 'asc']);
        $form = $this->createForm(FichierType::class, $fichier, ['scategories' => $scategories]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedScategories = $form->get('scategories')->getData();
            foreach ($selectedScategories as $scategorie) {
                $fichier->addScategory($scategorie);
            }
            $em->persist($fichier);
            $em->flush();
            $this->addFlash('notice', 'Fichier ajouté !');
            return $this->redirectToRoute('app_ajout_fichier');

        }

        return $this->render('fichier/ajout-fichier.html.twig', [
            'form' => $form->createView(),
            'scategories' => $scategories,
        ]);
    }
    #[Route('/private-liste-fichier', name: 'app_liste_fichier')]
    public function listefichier(FichierRepository $fichierRepository): Response
    {
        $fichier = $fichierRepository->findAll();
        return $this->render('fichier/liste-fichier.html.twig', [
            'fichier' => $fichier,
        ]);
    }

    #[Route('/liste-fichiers-par-utilisateur', name: 'app_liste_fichiers_par_utilisateur')]
    public function listeFichiersParUtilisateur(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['nom' => 'asc', 'prenom' => 'asc']);
        return $this->render('fichier/liste-fichiers-par-utilisateur.html.twig', ['users' => $users]);
    }
}
