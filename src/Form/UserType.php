<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class,array('label'=>"Email d'utilisateur",'attr'=>array('require'=>'require','class'=>'form-control form-group')))
           // ->add('password',TextType::class,array('label'=>'Mot Pass','attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('nom',TextType::class,array('label'=>"Nom d'utilisateur",'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('prenom',TextType::class,array('label'=>"Prenom d'utilisateur",'attr'=>array('require'=>'require','class'=>'form-control form-group')))
          //  ->add('role',EntityType::class,array('class'=>Role::class, 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('Valider',SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
