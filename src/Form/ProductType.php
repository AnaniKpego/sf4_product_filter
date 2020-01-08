<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label'=> 'Nom du produit',
                'required'=> true,
                'attr'=>[
                    'placeholder'=>'Nom du produit'
                ]
            ])
            ->add('price', NumberType::class,[
                'label'=>'Prix du produit',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Prix du produit'
                ]
            ])
            ->add('promo')
            ->add('description')
            ->add('content',TextareaType::class,[
                'label'=>'Contenu'
            ])
            ->add('image')
            ->add('categories',EntityType::class,[
                'class'=>Category::class,
                'label'=>'Catégorie',
                'required'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
