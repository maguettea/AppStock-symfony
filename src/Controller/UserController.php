<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping\ManyToMany;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/User', name: 'user_liste')]
    public function index(): Response
    {
        $en=$this->getDoctrine()->getManager();
        $u=new User();
        $form=$this->createForm(UserType::class,$u,
        array('action'=>$this->generateUrl('user_add')));
        $data['form']=$form->createView();
        $data['users']=$en->getRepository( User::class)->findAll();
        return $this->render('user/liste.html.twig',$data);
       
    }
    #[Route('/User/add', name: 'user_add')]
    public function add(Request $request): Response
    {
        $u=new User();
        $form=$this->createForm(UserType::class, $u);
        $form->handleRequest($request);
        if( $form->isSubmitted()&&  $form->isValid()){
            $u=$form->getData();
            $en=$this->getDoctrine()->getManager();
            $en->persist($u);
            $en->flush();
           

        }
        return $this->redirectToRoute('user_liste');
    }
}
