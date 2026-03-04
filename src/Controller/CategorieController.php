<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ModifierCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class CategorieController extends AbstractController
{
    #[Route('/liste-categories', name: 'liste-categories')]
    public function categorie(Request $request,CategorieRepository $categorieRepository,EntityManagerInterface $em): Response
    {
        $categories = $categorieRepository->findAll();
        return $this->render('categorie/liste-categories.html.twig', [
            'categories' => $categories,

        ]);
    }
    #[Route('/modifier-categorie/{id}', name: 'app_modifier_categorie')]

    public function modifierCategorie(Categorie $categorie): Response
    {

        $form = $this->createForm(ModifierCategorieType::class, $categorie);
        if($request->isMethod('POST')){
			$form->handleRequest($request);
			if ($form->isSubmitted()&&$form->isValid()){
				$em->persist($categorie);
				$em->flush();
				$this->addFlash('notice','Catégorie modifiée');
				return $this->redirectToRoute('app_liste_categories');
			}
		}	
        return $this->render('categorie/modifier-categorie.html.twig', [
		'form' => $form->createView()
        ]);
    }

}
