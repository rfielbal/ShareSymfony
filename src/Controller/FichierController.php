<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Fichier;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\FichierType;


final class FichierController extends AbstractController
{
    #[Route('/private-fichier', name: 'app_ajout_fichier')]
    public function ajoutFichier(Request $request, EntityManagerInterface $em): Response
    {
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier); 
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($fichier);
                $em->flush();
                $this->addFlash('notice', 'Fichier ajoutée');
                return $this->redirectToRoute('app_ajout_fichier');
            }
        }
        return $this->render('fichier/ajout-fichier.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
