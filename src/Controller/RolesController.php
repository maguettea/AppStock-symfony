<?php

namespace App\Controller;

use App\Form\RoleType;
use App\Entity\Role;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping\ManyToMany;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RolesController extends AbstractController
{
    #[Route('/Role', name: 'role_liste')]
    public function index(): Response
    {
        $en=$this->getDoctrine()->getManager();
        $r=new Role();
        $form=$this->createForm(RoleType::class,$r,
       array('action'=>$this->generateUrl('role_add')));
       $data['form']=$form->createView();
        $data['role']=$en->getRepository( Role::class)->findAll();
        return $this->render('role/liste.html.twig',$data);
       
    }
    #[Route('/Role/add', name: 'role_add')]
    public function add(Request $request): Response
    {
        $r=new Role();
        $form=$this->createForm(RoleType::class, $r);
        $form->handleRequest($request);
        if( $form->isSubmitted()&&  $form->isValid()){
            $r=$form->getData();
            $en=$this->getDoctrine()->getManager();
            $en->persist($r);
            $en->flush();
           

        }
        return $this->redirectToRoute('role_liste');
    }
}
