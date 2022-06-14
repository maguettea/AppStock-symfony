<?php

namespace App\Form;


use App\Entity\Produit;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,array('label'=>'Libelle du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('stock',TextType::class,array('label'=>'Stock du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('categories',EntityType::class,array('class'=>Categorie::class, 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
           //->add('users',TextType::class,array('class'=>User::class, 'attr'=>array('require'=>'require','class'=>'form-control form-group')))
            ->add('Valider',SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
