<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name',TextType::class,[
                'label'=>'Nom',
                'required'=>true
            ])
            ->add('last_name',TextType::class,[
                'label'=>'Prenom(s)',
                'required'=>true
            ])
            ->add('email',EmailType::class,[
                'label'=>'Email',
                'required'=>true
            ])
            ->add('country',TextType::class,[
                'required'=>true,
                'label'=>'Pays'
            ])
            ->add('city',TextType::class,[
                'required'=>true,
                'label'=>'Ville'
            ])
            ->add('postal_code',TextType::class,[
                'required'=>true,
                'label'=>'Code Postal'
            ])
            ->add('adress',TextType::class,[
                'required'=>true,
                'label'=>'Adresse'
            ])
            ->add('password',PasswordType::class,[
                'label'=>'Mot de passe',
                'required'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
