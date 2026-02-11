<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;

final class CategorieController extends AbstractController
{
    #[Route('/liste-categories', name: 'liste-categories')]
    public function categorie(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();
        return $this->render('categorie/liste-categories.html.twig', [
		'categories' => $categories
            
        ]);
    }
}
