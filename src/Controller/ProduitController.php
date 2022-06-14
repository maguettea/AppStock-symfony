<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/Produit', name: 'produit_liste')]
    public function index(): Response
    {
         $en=$this->getDoctrine()->getManager();
         $p=new Produit();
         $form=$this->createForm(ProduitType::class,$p,
        array('action'=>$this->generateUrl('produit_add')));
        $data['form']=$form->createView();
         $data['produits']=$en->getRepository( Produit::class)->findAll();
         return $this->render("produit/liste.html.twig",$data);
    }

    #[Route('/Produit/get/{id}', name: 'produit_get')]
    public function getProduit($id): Response
    {
        return $this->render('produit/liste.html.twig');
    }

    #[Route('/Produit/add', name: 'produit_add')]
    public function add(Request $request): Response
    {
        $p=new Produit();
        $form=$this->createForm(ProduitType::class, $p);
        $form->handleRequest($request);
        if( $form->isSubmitted()&&  $form->isValid()){
            $p=$form->getData();
            $en=$this->getDoctrine()->getManager();
            $en->persist($p);
            $en->flush();
           

        }
        return $this->redirectToRoute('produit_liste');
    }
    #[Route('/Produit/edit/{id}', name: 'produit_edit')]
    public function edit(ManagerRegistry $doctrine, $id): Response
    {
        $en = $doctrine->getManager();

        //$entityManager = $this->getDoctrine()->getManager();
        $p = $en->getRepository(Produit::class)->find($id);

        $form = $this->createForm(ProduitType::class, $p, array('action' => $this->generateUrl('produit_update', ['id' => $id])));
        $data['form'] = $form->createView();

        $data['produits'] = $en->getRepository(Produit::class)->findAll();
        return $this->render('produit/liste.html.twig', $data);
    }
          //function update -> Modification de produit
    #[Route('/Produit/update/{id}', name: 'produit_update')]
    public function update(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $en = $doctrine->getManager();

        //instanciation du produit
        $p = new Produit();
        $form = $this->createForm(ProduitType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $p = $form->getData();
            // recuperation de l'id du User 
            $p->setUser($this->getUser());
            $p->setId($id);

            //$entityManager = $this->getDoctrine()->getManager();
            $produit = $en->getRepository(Produit::class)->find($id);
            $produit->setLibelle($p->getLibelle());
            $en->flush();


            return $this->redirectToRoute('produit_liste');
        }
    }
      //function delete -> Suppression de produit
    #[Route('/Produit/delete/{id}', name: 'produit_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $en = $doctrine->getManager();

        //$entityManager = $this->getDoctrine()->getManager();
        $produit = $en->getRepository(Produit::class)->find($id);
        if ($produit != NULL) 
        {
            $en->remove($produit);
            $en->flush();
        }
        return $this->redirectToRoute('produit_liste');
        
    }     
}
