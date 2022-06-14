<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Produit;
use App\Form\EntreeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EntreeController extends AbstractController
{
    #[Route('/Entree', name: 'entree_liste')]
    public function index(): Response
    {
        $en=$this->getDoctrine()->getManager();
        $e=new Entree();
        $form=$this->createForm(EntreeType::class,$e,
        array('action'=>$this->generateUrl('entree_add')));
        $data['form']=$form->createView();
        $data['entrees']=$en->getRepository( Entree::class)->findAll();
        return $this->render('entree/liste.html.twig',$data);
    }
    #[Route('/Entree/add', name: 'entree_add')]
    public function add(Request $request): Response
    {
        $e=new Entree();
        $form=$this->createForm(EntreeType::class, $e);
        $form->handleRequest($request);
        if( $form->isSubmitted() &&  $form->isValid()){
            $e=$form->getData();
            
            $en=$this->getDoctrine()->getManager();
            $en->persist($e);
            $en->flush();
            //mise à jour du Produit 
             $p=$en->getRepository(Produit::class)->find($e->getProduit()->getId());
              $stoc=$p->getStock() + $e->getQte();
                $p->setStock($stoc);
            $en->flush();
        }
        return $this->redirectToRoute('entree_liste');
    }
}
