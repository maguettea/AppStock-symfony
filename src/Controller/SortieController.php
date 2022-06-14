<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Produit;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SortieController extends AbstractController
{
    #[Route('/Sortie', name: 'sortie_liste')]
    public function index(): Response
    {
        $en=$this->getDoctrine()->getManager();
        $s=new Sortie();
        $form=$this->createForm(SortieType::class,$s,
        array('action'=>$this->generateUrl('sortie_add')));
        $data['form']=$form->createView();
        $data['sorties']=$en->getRepository( Sortie::class)->findAll();
        return $this->render('sortie/liste.html.twig',$data);
    } 
    #[Route('/Sortie/add', name: 'sortie_add')]
    public function add(Request $request): Response
    {
        
        $s=new Sortie();
        $form=$this->createForm(SortieType::class, $s);
        $form->handleRequest($request);

        if( $form->isSubmitted() &&  $form->isValid()){
            $en=$this->getDoctrine()->getManager();
            $s=$form->getData();
            $qsortie=$s->getQte();
            $p=$en->getRepository(Produit::class)->find($s->getProduit()->getId());

            if($p->getStock() < $s->getQte()){
                 $s=new Sortie();
                 $form=$this->createForm(SortieType::class,$s,
                array('action'=>$this->generateUrl('sortie_add')));
                $data['form']=$form->createView();
                $data['sorties']=$en->getRepository( Sortie::class)->findAll();
                $data['error_message']='le Stock disponile est inférieur à'.$s->getQte();
                return $this->render('sortie/liste.html.twig',$data);  
             }
             else{
                $en->persist($s);
                $en->flush();
                 //mise à jour du Produit 
                 $stoc= $p->getStock() - $s->getQte();
                 $p->setStock($stoc);
                 $en->flush();
                 return $this->redirectToRoute('sortie_liste');
                
                }  
            
        }
      
    }
    
}
