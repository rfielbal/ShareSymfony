<?php
namespace App\Controller;

use App\Entity\Scategorie;
use App\Form\ModifierScategorieType;
use App\Form\SupprimerCategorieType;
use App\Form\AjoutScategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ScategorieController extends AbstractController
{
    #[Route('/ajout-scategorie', name: 'app_ajout_scategorie')]
    public function ajoutScategorie(Request $request, EntityManagerInterface $em): Response
    {
        $scategorie = new Scategorie();
        $form = $this->createForm(AjoutScategorieType::class, $scategorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                try {
                    $em->persist($scategorie);
                    $em->flush();
                } catch (\RuntimeException $e) {
                    $this->addFlash('notice', $e->getMessage());
                    return $this->redirectToRoute('app_ajout_scategorie');
                }
                $this->addFlash('notice', 'Sous catégorie insérée');
                return $this->redirectToRoute('app_ajout_scategorie');
            }
        }
        return $this->render('scategorie/ajout-scategorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/private-modifier-scategorie/{id}', name: 'app_modifier_scategorie')]

    public function modifierCategorie(Request $request,Scategorie $scategorie,EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ModifierScategorieType::class, $scategorie);
		if($request->isMethod('POST')){
			$form->handleRequest($request);
			if ($form->isSubmitted()&&$form->isValid()){
				$em->persist($scategorie);
				$em->flush();
				$this->addFlash('notice','Sous-catégorie modifiée');
				return $this->redirectToRoute('app_liste_scategories');
			}
		}		
        return $this->render('scategorie/modifier-scategorie.html.twig', [
		'form' => $form->createView()
        ]);
    }
    #[Route('/private-supprimer-categorie/{id}', name: 'app_supprimer_categorie')]
	public function supprimerCategorie(Request $request,Categorie $categorie,EntityManagerInterface $em): Response
	{
		if($categorie!=null){
			$em->remove($categorie);
			$em->flush();
			$this->addFlash('notice','Catégorie supprimée');
	}
	return $this->redirectToRoute('app_liste_categories');
}
	
}
