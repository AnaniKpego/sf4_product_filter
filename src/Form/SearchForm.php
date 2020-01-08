<?php
/**
 * Created by PhpStorm.
 * User: PKDTECHNOLOGIESINC-K
 * Date: 09/12/2019
 * Time: 18:57
 */

namespace App\Form;


use App\Data\SearchData;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilder;

class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               ->add('q', TextType::class,[
                  'label'=> false,
                   'required'=> false,
                   'attr'=>[
                       'placeholder'=>'Rechercher un produit'
                   ]
               ])
               ->add('categories',EntityType::class,[
                   'class'=>Category::class,
                   'label'=>false,
                   'required'=>false,
                   'expanded'=> true,
                   'multiple'=>true,
               ])
               ->add('min', NumberType::class,[
                   'label'=>false,
                   'required'=>false,
                   'attr'=>[
                       'placeholder'=>'Prix min'
                   ]
               ])
               ->add('max', NumberType::class,[
                   'label'=>false,
                   'required'=>false,
                   'attr'=>[
                       'placeholder'=>'Prix max'
                   ]
               ])
               ->add('promo', CheckboxType::class,[
                   'label'=>'En promotion',
                   'required'=>false,
               ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>SearchData::class,
            'method'=>'GET',
            'csrf_protection' => false
        ]);

    }

    public function getBlockPrefix()
    {
        return '';
    }

}