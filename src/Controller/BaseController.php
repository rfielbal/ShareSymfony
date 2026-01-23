<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

class BaseController extends AbstractController
{
#[Route('/', name: 'app_accueil')]
public function index(): Response
{
return $this->render('base/index.html.twig', [
]);
}
#[Route('/contact', name: 'app_contact')]
public function contact(Request $request, EntityManagerInterface $em): Response
{
$contact = new Contact();
$form = $this->createForm(ContactType::class, $contact);
if($request->isMethod('POST')){
    $form->handleRequest($request);
    if ($form->isSubmitted()&&$form->isValid()){
        $em->persist($contact);
        $em->flush();
        $this->addFlash('notice','Message envoyé');
        return $this->redirectToRoute('app_contact');
    }
    }
return $this->render('base/contact.html.twig', [
'form' => $form->createView()
]);
}
#[Route('/apropos', name: 'app_apropos')]
public function apropos(): Response
{
return $this->render('base/apropos.html.twig', [
]);
}
#[Route('/mention', name: 'app_mention')]
public function mention(): Response
{
return $this->render('base/mention.html.twig', [
]);
}
}
