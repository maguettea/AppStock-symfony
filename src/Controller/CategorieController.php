<?php

namespace App\Controller;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'categorie_liste')]
    public function index(): Response
    {
        $en=$this->getDoctrine()->getManager();
        $c=new Categorie();
        $form=$this->createForm(CategorieType::class,$c,
       array('action'=>$this->generateUrl('categorie_add')));
       $data['form']=$form->createView();
        $data['categories']=$en->getRepository( Categorie::class)->findAll();
        return $this->render('categorie/liste.html.twig',$data);
       
    }
    #[Route('/Categorie/add', name: 'categorie_add')]
    public function add(Request $request): Response
    {
        $c=new Categorie();
        $form=$this->createForm(CategorieType::class, $c);
        $form->handleRequest($request);
        if( $form->isSubmitted()&&  $form->isValid()){
            $c=$form->getData();
            $en=$this->getDoctrine()->getManager();
            $en->persist($c);
            $en->flush();
           

        }
        return $this->redirectToRoute('categorie_liste');
    }
}
